<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

helper("text");
helper("string");

class SendMail extends BaseController
{
    // TODO masukkan log pada pengiriman pesan
    public function send()
    {
        $this->response->setHeader("content-type", 'application/json');
        $requests                = $this->request->getJSON(true);
        $notification_id         = strtolower(random_string('alpha', 16));
        $allowed_subjects        = ["pencarian", "teknis", "permintaan", "lainnya"];
        $newToken                = csrf_hash();
        $rules = [
            "namaLengkap"   => [
                "rules" => 'required',
                "errors" => [
                    "required" => "Input tidak boleh kosong."
                ]
            ],
            "email"         => [
                "rules" => 'required|valid_email',
                "errors" => [
                    "required" => "Input tidak boleh kosong.",
                    "valid_email" => "Format email tidak valid."
                ]
            ],
            "noTelp"        => [
                "rules" => 'required|regex_match[/^08/]|regex_match[/[\d]{10,13}/]',
                "errors" => [
                    "required" => "Input tidak boleh kosong.",
                    "regex_match" => "Format nomor HP tidak valid."
                ]
            ],
            "subject"       => [
                "rules" => 'in_list[pencarian,teknis,permintaan,lainnya]',
                "errors" => [
                    "in_list" => "Pilih subjek anda."
                ]
            ],
            "message"       => [
                "rules" => 'required|min_length[30]',
                "errors" => [
                    "required" => 'Input tidak boleh kosong.',
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
        $nama_lengkap_pengguna   = $requests["namaLengkap"];
        $nomor_telpon            = $requests["noTelp"];
        $user_email              = $requests["email"];
        $subjek                  = $requests["subject"];
        $pesan                   = $requests["message"];
        if (!in_array(strtolower($subjek), $allowed_subjects)) {
            $this->response->setStatusCode(400);
            return $this->response->setJSON([
                "status"         => 400,
                "notificationId" => $notification_id,
                "notification"   => view('components/notification', [
                    "notificationId"    => $notification_id,
                    "title"             => "Pengiriman Pesan",
                    "message"           => "Subjek tidak diizinkan."
                ]),
                "newToken"       => $newToken
            ]);
        }
        $email_service  = Services::email();
        $to             = "fattahillahmuhammad48@gmail.com";
        $setReplyTo     = $user_email;
        $message        = "Laporan dari Pengguna<br>";
        $message       .= "Nama Pengguna: " . esc($nama_lengkap_pengguna) . "<br>";
        $message       .= "Nomor Telpon Pengguna: " . esc($nomor_telpon) . "<br>";
        $message       .= "Email Pengguna: " . esc($user_email) . "<br>";
        $message       .= "Pesan: " . esc($pesan);
        $email_service->setTo($to);
        $email_service->setReplyTo($setReplyTo, $nama_lengkap_pengguna);
        $email_service->setSubject(esc($subjek));
        $email_service->setMessage($message);
        if ($email_service->send()) {
            $this->response->setStatusCode(200);
            return $this->response->setJSON([
                "status"            => 200,
                "notificationId"    => $notification_id,
                "notification"      => view('components/notification', [
                    "notificationId"    => $notification_id,
                    "title"             => "Pengiriman Pesan",
                    "message"           => "Pesan berhasil Terkirim.",
                ]),
                "newToken"          => $newToken,
            ]);
        } else {
            $this->response->setStatusCode(400);
            return $this->response->setJSON([
                "status"            => 400,
                "notificationId"    => $notification_id,
                "notification"      => view('components/notification', [
                    "notificationId"    => $notification_id,
                    "title"             => "Pengiriman Pesan",
                    "message"           => "Pesan gagal terkirim."
                ]),
                "newToken"          => $newToken,
            ]);
        }
    }
}
