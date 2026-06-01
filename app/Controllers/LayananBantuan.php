<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\FrontendConfig;
use App\Models\PagesMeta;
use App\Models\TopikBantuan;

class LayananBantuan extends BaseController
{
    private $fe_config_model;
    private $pages_meta_model;
    private $topik_bantuan_model;
    public function __construct()
    {
        $this->fe_config_model      = new FrontendConfig;
        $this->pages_meta_model     = new PagesMeta;
        $this->topik_bantuan_model  = new TopikBantuan;
    }
    public function index()
    {
        $data_feconfig = $this->fe_config_model->getAllData();
        $page_title = "Layanan Bantuan JDIH DPRD Kabupaten Batang Hari | Kontak & Dukungan Pengguna";
        $page_alias = "Layanan Bantuan";
        $page_description = "Hubungi layanan bantuan JDIH DPRD Kabupaten Batang Hari untuk panduan penggunaan portal, bantuan pencarian dokumen hukum, pengajuan permintaan dokumen, serta dukungan teknis melalui layanan kontak dan email resmi.";
        $page_keywords = [
            "Layanan Bantuan JDIH",
            "Bantuan JDIH DPRD Batang Hari",
            "Kontak JDIH",
            "Dukungan Pengguna JDIH",
            "Bantuan Pencarian Dokumen",
            "Pengajuan Dokumen Hukum",
            "Help Center JDIH",
            "FAQ JDIH",
            "Dokumentasi Hukum Daerah",
            "Dukungan Teknis JDIH",
            "Portal JDIH Kabupaten Batang Hari",
        ];
        $other_meta = [
            "pages_meta"        => $this->pages_meta_model->getMetaPagesByIdentity("Bantuan"),
            "topik_bantuan"     => $this->topik_bantuan_model->getTopicsHelp(),
        ];
        $page_data = create_page_meta(
            $page_title,
            $page_alias,
            $page_description,
            $page_keywords,
            $data_feconfig,
            $other_meta
        );
        return view('pages/bantuan', $page_data);
    }
}
