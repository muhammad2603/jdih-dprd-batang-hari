<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\FrontendConfig;

class SyaratKetentuan extends BaseController
{
    private $fe_config_model;
    public function __construct()
    {
        $this->fe_config_model = new FrontendConfig;
    }
    public function index()
    {
        $data_feconfig = $this->fe_config_model->getAllData();
        $page_title = "Syarat dan Ketentuan Penggunaan Layanan | JDIH DPRD Kabupaten Batang Hari";
        $page_alias = "Syarat & Ketentuan";
        $page_description = "Menjelaskan syarat dan ketentuan penggunaan layanan JDIH DPRD Kabupaten Batang Hari, termasuk ketentuan akses informasi hukum daerah, batasan penggunaan data, serta tanggung jawab pengguna layanan.";
        $page_keywords = [
            "Syarat dan Ketentuan",
            "Terms and Conditions JDIH",
            "Ketentuan Penggunaan JDIH DPRD Kabupaten Batang Hari",
            "Aturan Layanan JDIH",
            "JDIH Kabupaten Batang Hari",
            "Informasi Hukum Daerah",
            "Dokumentasi Hukum Resmi",
            "Produk Hukum Daerah",
        ];
        $other_meta = [];
        $page_data = create_page_meta(
            $page_title,
            $page_alias,
            $page_description,
            $page_keywords,
            $data_feconfig,
            $other_meta
        );
        return view('pages/syarat_ketentuan', $page_data);
    }
}
