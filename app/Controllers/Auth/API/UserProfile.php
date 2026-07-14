<?php

namespace App\Controllers\Auth\API;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserProfile as UserProfileModel;
use App\Models\UserModel;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Database\BaseConnection;
use Config\Database;
use Exception;

class UserProfile extends BaseController
{
    private UserProfileModel $user_profile_model;
    private User $user;
    private UserModel $userProvider;
    private BaseConnection $db;
    private object $passwords;

    public function __construct()
    {
        $this->passwords            = service('passwords');
        $this->userProvider         = auth()->getProvider();
        $this->user                 = auth()->user();
        $this->db                   = Database::connect();
        $this->user_profile_model   = new UserProfileModel;
    }

    /**
     * Kirim response gagal yang mengirimkan token csrf hash baru
     * 
     * @param int $errorCode kode response
     * @param string|array $message pesan tambahan yang akan dikirim ke client/fetch
     * @return ResponseInterface
     */
    private function setErrorResponse($message, $errorCode = 400)
    {
        return $this->response
            ->setStatusCode($errorCode)
            ->setJSON([
                "success" => false,
                "message" => $message,
                "new_token" => csrf_hash()
            ]);
    }

    /**
     * Membuat log berdasarkan operasi yang dilakukan
     * 
     * @param string $level level log
     * @param int $user_id ID user yang mengakses API ini
     * @param string $username username yang mengakses API ini
     * @param string $operation operasi yang dilakukan.
     * @param string $message pesan log
     * @return void
     */
    private function setLogMessage(string $level, int $user_id, string $username, string $operation, string $message): void
    {
        log_message($level, "[ID: $user_id - User $username] [$operation]: $message");
    }

    public function update()
    {
        if (!$this->request->isAJAX()) {
            return self::setErrorResponse("Permintaan gagal dipenuhi! Permintaan harus berasal dari AJAX!");
        }
        $user_id    = $this->user->id;
        $username   = $this->user->username;
        if (!$user_id || !$username) {
            return self::setErrorResponse("Nama pengguna anda tidak ditemukan!");
        }
        if ($this->user->isBanned()) {
            return self::setErrorResponse("Mohon maaf! Akun anda telah dibanned dengan alasan: " . $this->user->getBanMessage());
        }
        $rules = [
            "nama_lengkap" => [
                "rules" => 'permit_empty|min_length[3]|max_length[50]|regex_match[/^[A-Za-z\. ]+$/]',
                "errors" => [
                    "min_length" => 'Nama lengkap tidak valid! Minimal 3 huruf.',
                    "max_length" => 'Nama lengkap tidak valid! Maksimal 50 huruf.',
                    "regex_match" => 'Nama lengkap hanya mengandung karakter alfabet (a-z), titik, dan spasi.'
                ]
            ],
            "nama_divisi" => [
                "rules" => 'permit_empty|min_length[5]|max_length[30]',
                "errors" => [
                    "min_length" => 'Nama divisi tidak valid! Minimal 3 huruf.',
                    "max_length" => 'Nama divisi tidak valid! Maksimal 30 huruf.'
                ]
            ],
            "nomor_hp" => [
                "rules" => 'permit_empty|min_length[10]|max_length[13]|regex_match[/^\d+$/]|regex_match[/^08/]',
                "errors" => [
                    "min_length" => 'Nomor HP tidak valid! Minimal 10 digit/angka.',
                    "max_length" => 'Nomor HP tidak valid! Maksimal 13 digit/angka.',
                    "regex_match" => 'Format Nomor HP tidak valid! Pastikan hanya mengandung digit/angka dan diawali dengan 08!'
                ]
            ],
            "currentPassword" => [
                "rules" => 'permit_empty|required_with[newPassword]|required_with[confirmNewPassword]|min_length[8]',
                "errors" => [
                    "required_with" => 'Data tidak lengkap untuk melakukan pergantian password!',
                    "min_length" => 'Password tidak valid! Minimal 8 karakter.'
                ]
            ],
            "newPassword" => [
                "rules" => 'permit_empty|required_with[currentPassword]|required_with[confirmNewPassword]|min_length[8]|regex_match[/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^A-Za-z0-9])[A-Za-z\d@$!%*?&]{8,}$/]',
                "errors" => [
                    "required_with" => 'Data tidak lengkap untuk melakukan pergantian password!',
                    "min_length" => 'Password tidak valid! Minimal 8 karakter.',
                    "regex_match" => 'Format password tidak valid! Karakter password setidaknya mengandung 1 huruf besar dan 1 huruf kecil, 1 angka, 1 simbol (!@#$%^&*), dan minimal panjang 8 karakter!'
                ]
            ],
            "confirmNewPassword" => [
                "rules" => 'permit_empty|required_with[currentPassword]|required_with[newPassword]|matches[newPassword]',
                "errors" => [
                    "required_with" => 'Data tidak lengkap untuk melakukan pergantian password!',
                    "matches" => 'Password konfirmasi tidak cocok dengan password baru!'
                ]
            ],
        ];
        if (!$this->validate($rules)) return $this->response->setStatusCode(400)
            ->setJSON([
                "status" => false,
                "message" => $this->validator->getErrors(),
                "new_token" => csrf_hash()
            ]);
        $requests = $this->request->getPost();
        $table_users_profile = [
            "nama_lengkap",
            "nama_divisi",
            "nomor_hp"
        ];
        $users_profile_changes = [];
        foreach ($requests as $req_name => $value) {
            if (in_array($req_name, $table_users_profile)) {
                $dbField = $req_name;
                $users_profile_changes[$dbField] = $value;
            }
        }
        $is_password_change = isset($requests["currentPassword"]) && isset($requests["newPassword"]) && isset($requests["confirmNewPassword"]);
        $is_valid_password_to_change = false;
        if ($is_password_change) {
            $get_current_password = $requests["currentPassword"];
            $is_curr_password_valid = $this->passwords->verify($get_current_password, $this->user->password_hash);
            if (!$is_curr_password_valid) return self::setErrorResponse("Password saat ini tidak benar! Coba lagi dan isi dengan benar.");
            $is_valid_password_to_change = true;
        }
        $this->db->transStart();
        try {
            if (count($users_profile_changes) > 0) {
                $this->user_profile_model
                    ->set($users_profile_changes)
                    ->where("user_id", $user_id)
                    ->update();
            }
            if ($is_valid_password_to_change) {
                $get_new_password = $requests["newPassword"];
                $user = $this->userProvider->findById($user_id);
                $user->fill([
                    "password" => $get_new_password
                ]);
                $is_pass_changed = $this->userProvider->save($user);
            }
            $this->db->transComplete();
            if ($this->db->transStatus() === false) throw new Exception($this->db->error()["message"]);
        } catch (\Throwable $e) {
            $this->db->transRollback();
            self::setLogMessage("critical", $user_id, $username, "UPDATE USER PROFILE", $e->getMessage());
            self::setErrorResponse("Terjadi kesalahan. Mohon hubungi administrator untuk memperbaiki masalah ini lebih lanjut!");
            return;
        }
        if (isset($is_pass_changed) && $is_pass_changed) {
            auth()->logout();
        }
        return $this->response
            ->setJSON([
                "status" => true,
                "message" => "Update profil berhasil!",
            ]);
    }
}
