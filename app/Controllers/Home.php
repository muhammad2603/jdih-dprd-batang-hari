<?php

namespace App\Controllers;

use App\Models\FrontendConfig;

class Home extends BaseController
{
    private $frontend_config;

    public function __construct()
    {
        $this->frontend_config = new FrontendConfig;
    }

    // __FIX__ page_alias dan frontend_config di array $page_data harus dipanggil disetiap halaman, perbaiki hal tersebut tanpa perlu membuat manual disetiap Controller-nya
    public function index(): string
    {
        $get_all_data_feconfig = $this->frontend_config->getAllData();
        $page_data = [
            "page_title"        => 'Layanan JDIH DPRD Kabupaten Batang Hari',
            "page_description"  => 'Website resmi JDIH DPRD Kabupaten Batang Hari untuk publikasi dokumen hukum daerah.',
            "page_keywords"     => ['JDIH', 'DPRD Batang Hari', 'Layanan DPRD Batang Hari', 'Informasi Dokumen Hukum'],
            "page_author"       => 'DPRD Batang Hari',
            "page_alias"        => 'Beranda',
            "frontend_config"   => array_group_by($get_all_data_feconfig, ["component", "category"]),
        ];
        return view('home', $page_data);
    }
}
