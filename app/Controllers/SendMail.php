<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

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

        $email_service = Services::email();
        $to = "fattahillahmuhammad@gmail.com";
        $setReplyTo = $user_email;
        $message = "Laporan dari Pengguna\n";
        $message .= "Nama Pengguna: $nama_lengkap_pengguna\n";
        $message .= "Nomor Telpon Pengguna: $nomor_telpon\n";
        $message .= "Email Pengguna: $user_email\n";
        $message .= "Pesan: $pesan";

        $email_service->setTo($to);
        $email_service->setReplyTo($setReplyTo, $nama_lengkap_pengguna);
        $email_service->setSubject($subjek);
        $email_service->setMessage($message);

        //! Response
        if ($email_service->send()) {
            $this->response->setStatusCode(200);
            return $this->response->setJSON([
                "status" => 200,
                "message" => "Pesan berhasil terkirim."
            ]);
        } else {
            $this->response->setStatusCode(400);
            return $this->response->setJSON([
                "status" => 400,
                "message" => "Pesan gagal terkirim."
            ]);
        }
    }
}
