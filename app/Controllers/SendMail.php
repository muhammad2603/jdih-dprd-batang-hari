<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

helper("text");

class SendMail extends BaseController
{
    public function send()
    {
        $this->response->setHeader("content-type", 'application/json');
        $requests                = $this->request->getJSON();
        $nama_lengkap_pengguna   = $requests->namaLengkap;
        $nomor_telpon            = $requests->nomorTelpon;
        $user_email              = $requests->userEmail;
        $subjek                  = $requests->subjek;
        $pesan                   = $requests->pesan;
        $notification_id         = strtolower(random_string('alpha', 16));
        $allowed_subjects        = ["pencarian", "teknis", "permintaan", "lainnya"];
        if (!in_array($subjek, $allowed_subjects)) {
            $this->response->setStatusCode(400);
            return $this->response->setJSON([
                "status" => 400,
                "notificationId" => $notification_id,
                "notification" => view('components/notification', [
                    "notificationId" => $notification_id,
                    "title" => "Pengiriman Pesan",
                    "message" => "Subjek tidak diizinkan."
                ])
            ]);
        }
        $email_service = Services::email();
        $to = "fattahillahmuhammad@gmail.com";
        //! Cek saat pesan terkirim ke $to, dan dibalas, apakah akan masuk ke email pengguna di $setReplyTo?
        $setReplyTo = $user_email;
        $message = "Laporan dari Pengguna\n";
        $message .= "Nama Pengguna: " . esc($nama_lengkap_pengguna) . "\n";
        $message .= "Nomor Telpon Pengguna: " . esc($nomor_telpon) . "\n";
        $message .= "Email Pengguna: " . esc($user_email) . "\n";
        $message .= "Pesan: " . esc($pesan);
        $email_service->setTo($to);
        $email_service->setReplyTo($setReplyTo, $nama_lengkap_pengguna);
        $email_service->setSubject(esc($subjek));
        $email_service->setMessage($message);
        if ($email_service->send()) {
            $this->response->setStatusCode(200);
            return $this->response->setJSON([
                "status" => 200,
                "notificationId" => $notification_id,
                "notification" => view('components/notification', [
                    "notificationId" => $notification_id,
                    "title" => "Pengiriman Pesan",
                    "message" => "Pesan berhasil Terkirim."
                ]),
            ]);
        } else {
            $this->response->setStatusCode(400);
            return $this->response->setJSON([
                "status" => 400,
                "notificationId" => $notification_id,
                "notification" => view('components/notification', [
                    "notificationId" => $notification_id,
                    "title" => "Pengiriman Pesan",
                    "message" => "Pesan gagal terkirim."
                ]),
            ]);
        }
    }
}
