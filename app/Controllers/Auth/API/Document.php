<?php

declare(strict_types=1);

namespace App\Controllers\Auth\API;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use Exception;
use CodeIgniter\Database\BaseConnection;
use Config\Database;
use App\Models\ProdukHukum;
use App\Models\MetaProdukHukum;
use App\Models\RiwayatPerubahanProdukHukum;
use App\Models\RiwayatDetailPerubahan;
use App\Models\KlasifikasiBidangHukum;
use App\Models\KlasifikasiSubjek;
use App\Models\RelatedDocument;
use App\Models\LampiranProdukHukum;
use CodeIgniter\Shield\Entities\User;

class Document extends ResourceController
{
    private BaseConnection $db;
    private ProdukHukum $ph_model;
    private MetaProdukHukum $meta_ph_model;
    private RiwayatPerubahanProdukHukum $rpph_model;
    private RiwayatDetailPerubahan $rdp_model;
    private KlasifikasiBidangHukum $kbh_model;
    private KlasifikasiSubjek $ks_model;
    private RelatedDocument $rd_model;
    private LampiranProdukHukum $lph_model;
    private User|null $user;
    public function __construct()
    {
        $this->db               = Database::connect();
        $this->user             = auth()->user();
        $this->ph_model         = new ProdukHukum;
        $this->meta_ph_model    = new MetaProdukHukum;
        $this->rpph_model       = new RiwayatPerubahanProdukHukum;
        $this->rdp_model        = new RiwayatDetailPerubahan;
        $this->kbh_model        = new KlasifikasiBidangHukum;
        $this->ks_model         = new KlasifikasiSubjek;
        $this->rd_model         = new RelatedDocument;
        $this->lph_model        = new LampiranProdukHukum;
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
     * @param string $operation operasi yang dilakukan. Cth: Create Document, Delete Document, dsb.
     * @param string $message pesan log
     * @return void
     */
    private function setLogMessage(string $level, int $user_id, string $username, string $operation, string $message): void
    {
        log_message($level, "[ID: $user_id - User $username] [$operation]: $message");
    }

    /**
     * Cek apakah akun user yang terautentikasi dibanned?
     * 
     * @return bool true jika akun user dibanned
     */
    private function isUserGotBanned(): bool
    {
        return $this->user->isBanned();
    }

    /**
     * Cek apakah user diizinkan untuk melakukan operasi CRUD pada dokumen?
     * 
     * @param string $permission operasi yang diizinkan. list permission: create|update|delete
     * @return bool true jika user diizinkan
     */
    private function isUserHasPermission(string $permission): bool
    {
        return $this->user->can("document." . $permission);
    }

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        //
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Membuat dokumen baru
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $user = auth()->user();
        if (!$user->can("document.create")) {
            return self::setErrorResponse("Maaf, anda tidak dapat menambahkan dokumen. Operasi tidak diizinkan.");
        }
        if ($user->isBanned()) {
            return self::setErrorResponse("Maaf, akun anda telah dibanned, alasan: {$this->user->getBanMessage()}. Hubungi administrator untuk mengaktifkan akun anda kembali.");
        }
        $rules = [
            'judul_dokumen' => [
                'label' => 'Judul dokumen',
                'rules' => 'required|min_length[5]|max_length[255]|is_unique[produk_hukum.title]',
            ],
            'nomor_dokumen' => [
                'label' => 'Nomor dokumen',
                'rules' => 'required|numeric',
            ],
            'tahun_dokumen' => [
                'label' => 'Tahun dokumen',
                'rules' => 'required|numeric|exact_length[4]',
            ],
            'nomor_tld' => [
                'label' => 'Nomor TLD',
                'rules' => 'required|numeric',
            ],
            'tahun_tld' => [
                'label' => 'Tahun TLD',
                'rules' => 'required|numeric|exact_length[4]',
            ],
            'jenis_dokumen' => [
                'label' => 'Jenis dokumen',
                'rules' => 'required|numeric',
            ],
            'status_dokumen' => [
                'label' => 'Status dokumen',
                'rules' => 'required|numeric',
            ],
            'teu_dokumen' => [
                'label' => 'TEU dokumen',
                'rules' => 'required|numeric',
            ],
            'tanggal_penetapan' => [
                'label' => 'Tanggal penetapan',
                'rules' => 'required|valid_date',
            ],
            'tanggal_pengundangan' => [
                'label' => 'Tanggal pengundangan',
                'rules' => 'required|valid_date',
            ],
            'tanggal_berlaku' => [
                'label' => 'Tanggal berlaku',
                'rules' => 'required|valid_date',
            ],
            'pembuat_peraturan' => [
                'label' => 'Pembuat peraturan',
                'rules' => 'required|numeric',
            ],
            'pejabat_penandatanganan' => [
                'label' => 'Pembuat peraturan',
                'rules' => 'required|numeric',
            ],
            'pejabat_penetap' => [
                'label' => 'Pembuat peraturan',
                'rules' => 'required|numeric',
            ],
            'sumber' => [
                'label' => 'Sumber',
                'rules' => 'required|numeric',
            ],
            'judul_abstrak_pdf' => [
                'label' => 'Judul Abstrak',
                'rules' => 'permit_empty|min_length[5]|max_length[80]'
            ],
            'catatan' => [
                'label' => 'Catatan',
                'rules' => 'permit_empty|min_length[8]|max_length[255]',
            ],
            'komentar_perubahan' => [
                'label' => 'Komentar perubahan',
                'rules' => 'permit_empty|min_length[8]|max_length[255]',
            ],
        ];
        if (!$this->validate($rules)) {
            return self::setErrorResponse($this->validator->getErrors());
        }
        $request = $this->request;
        foreach (['tanggal_penetapan', 'tanggal_pengundangan', 'tanggal_berlaku'] as $tanggal) {
            if ($request->getPost($tanggal) > date('Y-m-d')) {
                return self::setErrorResponse("$tanggal tidak boleh lebih dari hari ini");
            }
        }
        $kategoriBidangHukum = json_decode($request->getPost('kategori_bidang_hukum'), true) ?? [];
        $kategoriSubjek = json_decode($request->getPost('kategori_subjek'), true) ?? [];
        $dokumenTerkait = json_decode($request->getPost('dokumen_terkait'), true) ?? [];
        foreach (array_merge($kategoriBidangHukum, $kategoriSubjek) as $id) {
            if (!is_numeric($id)) {
                return self::setErrorResponse('Kategori harus berupa ID angka');
            }
        }
        foreach ($dokumenTerkait as $item) {
            if (strlen($item['judul_dokumen_terkait']) < 8 || strlen($item['judul_dokumen_terkait']) > 255) {
                return self::setErrorResponse('Judul dokumen terkait tidak valid');
            }
            foreach (['nomor_dokumen_terkait', 'tahun_dokumen_terkait', 'jenis_dokumen_terkait', 'aksi_dokumen_terkait'] as $field) {
                if (!is_numeric($item[$field])) {
                    return self::setErrorResponse("$field harus angka");
                }
            }
            if (strlen($item['tahun_dokumen_terkait']) !== 4) {
                return self::setErrorResponse('Format tahun dokumen terkait salah');
            }
        }
        $temporary_path = WRITEPATH . 'uploads/temp/';
        $temporary_files = [];
        $abstrak = $request->getFile('abstrak_pdf');
        $abstrak_pdf_file_maxsize = 5 * (1024 * 1024);
        if ($abstrak && $abstrak->isValid()) {
            if (strtolower($abstrak->getClientExtension()) !== 'pdf') {
                return self::setErrorResponse("Abstrak harus PDF");
            }
            if ($abstrak->getMimeType() !== 'application/pdf') {
                return self::setErrorResponse("Abstrak bukan tipe PDF. Ganti file atau pastikan formatnya PDF.");
            }
            if ($abstrak->getSize() > $abstrak_pdf_file_maxsize) {
                return self::setErrorResponse('Abstrak maksimal 5 MB');
            }
            $abstrak_filename = $abstrak->getRandomName();
            $abstrak->move($temporary_path, $abstrak_filename);
        }
        $lampiran = $request->getFiles()['attachment_files'] ?? [];
        $judulLampiran = $request->getPost('attachment_titles') ?? [];
        $attachment_max_size = (30 * (1024 * 1024));
        $lampiran_lists = [];
        foreach ($lampiran as $key => $file) {
            if (!$file->isValid()) {
                continue;
            }
            if (strtolower($file->getClientExtension()) !== 'pdf') {
                return self::setErrorResponse("Lampiran {$judulLampiran[$key]} harus PDF.");
            }
            if ($file->getMimeType() !== 'application/pdf') {
                return self::setErrorResponse("Lampiran {$judulLampiran[$key]} bukan tipe PDF. Ganti file atau pastikan formatnya PDF.");
            }
            if ($file->getSize() > $attachment_max_size) {
                return self::setErrorResponse("Lampiran {$judulLampiran[$key]} maksimal 30 MB.");
            }
            if (!isset($judulLampiran[$key]) || strlen($judulLampiran[$key]) < 5 || strlen($judulLampiran[$key]) > 80) {
                return self::setErrorResponse("Judul lampiran {$judulLampiran[$key]} tidak valid.");
            }
            $filename = $file->getRandomName();
            $file->move($temporary_path, $filename);
            array_push($temporary_files, $filename);
            $lampiran_lists[$key]["title"] = $judulLampiran[$key];
            $lampiran_lists[$key]["filename"] = $filename;
        }
        $title_document             = esc($request->getPost("judul_dokumen"));
        $nomor_dokumen              = esc($request->getPost('nomor_dokumen'));
        $tahun_dokumen              = esc($request->getPost('tahun_dokumen'));
        $jenis_dokumen              = esc($request->getPost('jenis_dokumen'));
        $status_dokumen             = esc($request->getPost('status_dokumen'));
        $teu_dokumen                = esc($request->getPost('teu_dokumen'));
        $tanggal_penetapan          = esc($request->getPost('tanggal_penetapan'));
        $tanggal_pengundangan       = esc($request->getPost('tanggal_pengundangan'));
        $tanggal_berlaku            = esc($request->getPost('tanggal_berlaku'));
        $pembuat_peraturan          = esc($request->getPost('pembuat_peraturan'));
        $pejabat_penandatanganan    = esc($request->getPost('pejabat_penandatanganan'));
        $pejabat_penetap            = esc($request->getPost('pejabat_penetap'));
        $nomor_tld                  = esc($request->getPost('nomor_tld'));
        $tahun_tld                  = esc($request->getPost('tahun_tld'));
        $sumber                     = esc($request->getPost('sumber'));
        $tempat_penetapan           = esc($request->getPost('tempat_penetapan'));
        $catatan                    = str_replace(['"', "'"], "", esc($request->getPost('catatan')));
        $komentar_perubahan         = str_replace(['"', "'"], "", esc($request->getPost('komentar_perubahan')) ?? "Peraturan Daerah tentang $title_document ditetapkan dan diundangkan.");
        $slug                       = url_title($title_document, '-', true);
        $path_file_abstrak          = $abstrak_filename ?? null;
        $is_publish                 = 1; // Produk Hukum ditampilkan/dipublish diwebsite
        $rows_produk_hukum = [
            "title" => $title_document,
            "nomor" => $nomor_dokumen,
            "tahun" => $tahun_dokumen,
            "tanggal_penetapan" => $tanggal_penetapan,
            "tanggal_pengundangan" => $tanggal_pengundangan,
            "tanggal_berlaku" => $tanggal_berlaku,
            "tajuk_entri_utama" => $teu_dokumen,
            "category_id" => $jenis_dokumen,
            "status_id" => $status_dokumen,
            "slug" => $slug,
            "is_publish" => $is_publish,
            "updated_at" => null
        ];
        $this->db->transStart();
        try {
            $this->ph_model->insert($rows_produk_hukum);
            $new_ph_id = $this->ph_model->getInsertID();
            $this->meta_ph_model->insert([
                "ph_id" => $new_ph_id,
                "abstrak_pdf" => $path_file_abstrak,
                "catatan" => $catatan,
                "sumber_id" => $sumber,
                "tempat_penetapan" => $tempat_penetapan,
                "nomor_tld" => $nomor_tld,
                "tahun_tld" => $tahun_tld,
                "pembuat_peraturan" => $pembuat_peraturan,
                "penandatanganan" => $pejabat_penandatanganan,
                "pejabat_penetap" => $pejabat_penetap,
                "lokasi_terbit" => $tempat_penetapan,
            ]);
            if (count($kategoriBidangHukum) > 0) {
                foreach ($kategoriBidangHukum as $bidang_hukum_id) {
                    $this->kbh_model->save([
                        "ph_id" => $new_ph_id,
                        "bidang_hukum_id" => esc($bidang_hukum_id)
                    ]);
                }
            }
            if (count($kategoriSubjek) > 0) {
                foreach ($kategoriSubjek as $subjek_id) {
                    $this->ks_model->save([
                        "ph_id" => $new_ph_id,
                        "subjek_id" => esc($subjek_id)
                    ]);
                }
            }
            if (count($dokumenTerkait) > 0) {
                foreach ($dokumenTerkait as $dokumen) {
                    $this->rd_model->save([
                        "ph_id" => $new_ph_id,
                        "judul" => esc($dokumen["judul_dokumen_terkait"]),
                        "nomor" => esc($dokumen["nomor_dokumen_terkait"]),
                        "tahun" => esc($dokumen["tahun_dokumen_terkait"]),
                        "category_id" => esc($dokumen["jenis_dokumen_terkait"]),
                        "status_action" => esc($dokumen["aksi_dokumen_terkait"])
                    ]);
                }
            }
            $this->rdp_model->save(["comment" => $komentar_perubahan]);
            $this->rpph_model->save([
                "ph_id" => $new_ph_id,
                "rdp_id" => $this->rdp_model->getInsertID(),
            ]);
            foreach ($lampiran_lists ?? [] as $meta_file) {
                $this->lph_model->save([
                    "ph_id" => $new_ph_id,
                    "judul_berkas" => esc($meta_file["title"]),
                    "nama_berkas" => $meta_file["filename"]
                ]);
            }
            $this->db->transComplete();
            if ($this->db->transStatus() === false) {
                throw new Exception("Database gagal.");
            }
        } catch (\Throwable $e) {
            $this->db->transRollback();
            if ($path_file_abstrak !== null && file_exists($temporary_path . $path_file_abstrak)) {
                unlink($temporary_path . $path_file_abstrak);
            }
            foreach ($temporary_files as $filename) {
                $file_path = $temporary_path . $filename;
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
            self::setLogMessage("critical", $user->id, $user->username, "CREATE DOCUMENT", "Operasi gagal. Error: {$e->getMessage()}");
            return self::setErrorResponse($e->getMessage(), 500);
        }
        $get_abstrak_file_from_temp = $temporary_path . $path_file_abstrak;
        $abstrak_folder = FCPATH . 'assets/abstrak/';
        $dokumen_hukum_folder = WRITEPATH . 'uploads/dokumen-hukum/';
        if ($path_file_abstrak !== null && file_exists($get_abstrak_file_from_temp)) {
            rename(
                $get_abstrak_file_from_temp,
                $abstrak_folder . basename($get_abstrak_file_from_temp)
            );
        }
        foreach ($temporary_files ?? [] as $file) {
            $get_file_from_temp = $temporary_path . $file;
            $move_folder = $dokumen_hukum_folder . basename($file);
            if (file_exists(($get_file_from_temp))) {
                rename($get_file_from_temp, $move_folder);
            }
        }
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Dokumen berhasil ditambahkan.'
        ]);
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        if (self::isUserGotBanned()) {
            return self::setErrorResponse("Maaf, akun anda telah dibanned, alasan:{$this->user->getBanMessage()}. Hubungi administrator untuk mengaktifkan akun anda kembali.", 403);
        }
        if (!self::isUserHasPermission("delete")) {
            return self::setErrorResponse("Maaf, anda tidak dapat menghapus dokumen. Operasi tidak diizinkan.", 403);
        }
        $validate_id = $this->validateData(["id" => $id], ["id" => "required|is_natural_no_zero"]);
        if (!$validate_id) {
            return self::setErrorResponse("ID tidak valid.");
        }
        $is_data_exist = $this->db->table("produk_hukum")
            ->select("id")
            ->where("id", $id)
            ->get()->getFirstRow('array');

        if (is_null($is_data_exist)) {
            return self::setErrorResponse("Dokumen tidak ditemukan. Cek kembali apakah data masih tersedia.", 404);
        }
        $is_attachments_exist = $this->db->table('lampiran_produk_hukum')
            ->select("nama_berkas")
            ->where("ph_id", $id)
            ->get()->getResultArray();
        $get_abstract_file = $this->db->table('meta_produk_hukum')
            ->select("abstrak_pdf")
            ->where("ph_id", $id)
            ->where("abstrak_pdf IS NOT", null)
            ->get()->getResultArray()[0]["abstrak_pdf"] ?? null;
        $this->db->transStart();
        try {
            $this->ph_model->delete($id, true);
            $this->db->transComplete();
            if ($this->db->transStatus() === false) {
                throw new Exception("Gagal menghapus dokumen hukum");
            }
        } catch (\Throwable $e) {
            $this->db->transRollback();
            self::setLogMessage("critical", auth()->user()->id, auth()->user()->username, "DELETE DOCUMENT", "Gagal menghapus dokumen hukum dengan ID: {$id}. [{$e->getCode()}]: {$e->getMessage()}");
            return self::setErrorResponse($e->getMessage(), 500);
        }
        $attachment_path = WRITEPATH . 'uploads/dokumen-hukum/';
        foreach ($is_attachments_exist as $file) {
            $filename = $file["nama_berkas"];
            $is_file_exist = file_exists($attachment_path . $filename);
            if ($is_file_exist) {
                $remove_file = unlink($attachment_path . $filename);
                $attachments_deleted[] = $remove_file;
            }
        }
        $abstract_path = FCPATH . "assets/abstrak/";
        if ($get_abstract_file !== null && file_exists($abstract_path . $get_abstract_file)) {
            $remove_file = unlink($abstract_path . $get_abstract_file);
        }
        return $this->response->setJSON([
            "status" => true,
            "message" => "Dokumen berhasil dihapus secara permanen.",
            "new_token" => csrf_hash()
        ]);
    }
}
