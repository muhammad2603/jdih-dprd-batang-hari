<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\FrontendConfig;

class KebijakanPrivasi extends BaseController
{
    private $fe_config_model;
    public function __construct()
    {
        $this->fe_config_model = new FrontendConfig;
    }
    public function index()
    {
        $data_feconfig = $this->fe_config_model->getAllData();
        $page_title = "Kebijakan Privasi JDIH DPRD Kabupaten Batang Hari | Perlindungan Data Pengguna";
        $page_alias = "Kebijakan Privasi";
        $page_description = "Kebijakan Privasi JDIH DPRD Kabupaten Batang Hari yang menjelaskan pengelolaan data pengguna, penggunaan informasi, keamanan sistem, serta komitmen terhadap perlindungan privasi dalam layanan dokumentasi dan informasi hukum daerah.";
        $page_keywords = [
            "Kebijakan Privasi JDIH",
            "Privasi Pengguna JDIH",
            "Perlindungan Data Pengguna",
            "JDIH DPRD Kabupaten Batang Hari",
            "Keamanan Informasi Hukum",
            "Privasi Website Pemerintahan",
            "Dokumentasi Hukum Daerah",
            "Kebijakan Data Pengguna",
            "Sistem Informasi Hukum Daerah",
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
        return view('pages/kebijakan_privasi', $page_data);
    }
}
