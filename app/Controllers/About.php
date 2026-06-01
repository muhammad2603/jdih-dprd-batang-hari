<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\FrontendConfig;
use App\Models\PagesMeta;

class About extends BaseController
{
    private $fe_config_model;
    private $pages_meta_model;
    public function __construct()
    {
        $this->fe_config_model  = new FrontendConfig;
        $this->pages_meta_model = new PagesMeta;
    }
    public function index()
    {
        $data_feconfig = $this->fe_config_model->getAllData();
        $page_title = "Tentang JDIH DPRD Kabupaten Batang Hari";
        $page_alias = "Tentang";
        $page_description = "Halaman Tentang JDIH DPRD Kabupaten Batang Hari yang menyajikan profil lembaga, visi dan misi, nilai-nilai integritas, pelayanan, transparansi, serta informasi kontak dan jam operasional layanan dokumentasi hukum daerah.";
        $page_keywords = [
            "Tentang JDIH DPRD Batang Hari",
            "JDIH Kabupaten Batang Hari",
            "Profil JDIH DPRD",
            "Visi dan Misi JDIH",
            "Dokumentasi Hukum Daerah",
            "Informasi Hukum DPRD",
            "Transparansi Informasi Hukum",
            "Pelayanan Hukum Daerah",
            "Kontak JDIH DPRD Batang Hari",
            "JDIH Provinsi Jambi",
        ];
        $other_meta = [
            "page_meta" => $this->pages_meta_model->getMetaPagesByIdentity("Tentang"),
        ];
        $page_data = create_page_meta(
            $page_title,
            $page_alias,
            $page_description,
            $page_keywords,
            $data_feconfig,
            $other_meta
        );
        return view('pages/about', $page_data);
    }
}
