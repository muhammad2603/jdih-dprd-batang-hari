<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

helper("text");
helper("string");

class SendMail extends BaseController
{
    public function send()
    {
        $this->response->setHeader("content-type", 'application/json');
        $requests                = $this->request->getJSON(true);
        $notification_id         = strtolower(random_string('alpha', 16));
        $allowed_subjects        = ["Pencarian", "Teknis", "Permintaan", "Lainnya"];
        $newToken                = csrf_hash();
        $rules = [
            "namaLengkap"   => [
                "rules" => 'required',
                "errors" => [
                    "required" => "Isi nama lengkap anda."
                ]
            ],
            "email"         => [
                "rules" => 'required|valid_email',
                "errors" => [
                    "required" => "Isi alamat email anda.",
                    "valid_email" => "Format email tidak valid."
                ]
            ],
            "noTelp"        => [
                "rules" => 'required|regex_match[/^08/]|regex_match[/[\d]{10,13}/]',
                "errors" => [
                    "required" => "Isi nomor HP anda.",
                    "regex_match" => "Format nomor HP tidak valid."
                ]
            ],
            "subject"       => [
                "rules" => 'in_list[' . implode(",", $allowed_subjects) . ']',
                "errors" => [
                    "in_list" => "Pilih subjek anda."
                ]
            ],
            "message"       => [
                "rules" => 'required|min_length[30]',
                "errors" => [
                    "required" => 'Isi pesan anda.',
                    "min_length" => 'Pesan terlalu pendek, minimal 30 karakter.'
                ]
            ]
        ];
        if (!$this->validateData($requests, $rules)) {
            return $this->response->setJSON([
                "status"            => 200,
                "notificationId"    => $notification_id,
                "fieldsError"       => $this->validator->getErrors(),
                "notification"      => view('components/notification', [
                    "notificationId"    => $notification_id,
                    "title"             => "Pengiriman Pesan",
                    "message"           => "Pesan gagal terkirim.",
                ]),
                "newToken"          => $newToken,
            ])->setStatusCode(400);
        }
        $throttler               = service('throttler');
        $nama_lengkap_pengguna   = $requests["namaLengkap"];
        $nomor_telpon            = $requests["noTelp"];
        $user_email              = $requests["email"];
        $subjek                  = $requests["subject"];
        $pesan                   = $requests["message"];
        $token_by_full_name      = md5($nama_lengkap_pengguna);
        $token_by_phone_number   = md5($nomor_telpon);
        $token_by_user_email     = md5($user_email);
        $token_by_ip_address     = md5($this->request->getIPAddress());
        $req_throttler_limit     = 1;
        if (!$throttler->check($token_by_ip_address, $req_throttler_limit, MINUTE)) {
            return $this->response->setJSON([
                "status"            => 429,
                "notificationId"    => $notification_id,
                "notification"      => view('components/notification', [
                    "notificationId"    => $notification_id,
                    "title"             => "Pengiriman Pesan",
                    "message"           => "Terlalu banyak pengajuan, silahkan coba " . $throttler->getTokentime() . " detik lagi."
                ]),
                "newToken"          => $newToken,
            ])->setStatusCode(429);
        }
        if (!$throttler->check($token_by_full_name, $req_throttler_limit, MINUTE)) {
            return $this->response->setJSON([
                "status"            => 429,
                "notificationId"    => $notification_id,
                "notification"      => view('components/notification', [
                    "notificationId"    => $notification_id,
                    "title"             => "Pengiriman Pesan",
                    "message"           => "Terlalu banyak pengajuan, silahkan coba " . $throttler->getTokentime() . " detik lagi."
                ]),
                "newToken"          => $newToken,
            ])->setStatusCode(429);
        }
        if (!$throttler->check($token_by_phone_number, $req_throttler_limit, MINUTE)) {
            return $this->response->setJSON([
                "status"            => 429,
                "notificationId"    => $notification_id,
                "notification"      => view('components/notification', [
                    "notificationId"    => $notification_id,
                    "title"             => "Pengiriman Pesan",
                    "message"           => "Terlalu banyak pengajuan, silahkan coba " . $throttler->getTokentime() . " detik lagi."
                ]),
                "newToken"          => $newToken,
            ])->setStatusCode(429);
        }
        if (!$throttler->check($token_by_user_email, $req_throttler_limit, MINUTE)) {
            return $this->response->setJSON([
                "status"            => 429,
                "notificationId"    => $notification_id,
                "notification"      => view('components/notification', [
                    "notificationId"    => $notification_id,
                    "title"             => "Pengiriman Pesan",
                    "message"           => "Terlalu banyak pengajuan, silahkan coba " . $throttler->getTokentime() . " detik lagi."
                ]),
                "newToken"          => $newToken,
            ])->setStatusCode(429);
        }
        $email_service           = Services::email();
        $to                      = $_ENV["MAIL_REPLY"];
        $setReplyTo              = $user_email;
        $message                 = "Laporan dari Pengguna<br>";
        $message                .= "Nama Pengguna: " . esc($nama_lengkap_pengguna) . "<br>";
        $message                .= "Nomor Telpon Pengguna: " . esc($nomor_telpon) . "<br>";
        $message                .= "Email Pengguna: " . esc($user_email) . "<br>";
        $message                .= "Pesan: " . esc($pesan);
        $email_service->setTo($to);
        $email_service->setReplyTo($setReplyTo, $nama_lengkap_pengguna);
        $email_service->setSubject(esc($subjek));
        $email_service->setMessage($message);
        if ($email_service->send()) {
            return $this->response->setJSON([
                "status"            => 200,
                "notificationId"    => $notification_id,
                "notification"      => view('components/notification', [
                    "notificationId"    => $notification_id,
                    "title"             => "Pengiriman Pesan",
                    "message"           => "Pesan berhasil Terkirim.",
                ]),
                "newToken"          => $newToken,
            ])->setStatusCode(200);
        } else {
            log_message("error", "Email gagal terkirim: " . $email_service->printDebugger());
            log_message("info", "Email pengirim: " . $user_email);
            return $this->response->setJSON([
                "status"            => 400,
                "notificationId"    => $notification_id,
                "notification"      => view('components/notification', [
                    "notificationId"    => $notification_id,
                    "title"             => "Pengiriman Pesan",
                    "message"           => "Pesan gagal terkirim."
                ]),
                "newToken"          => $newToken,
            ])->setStatusCode(400);
        }
    }
}
