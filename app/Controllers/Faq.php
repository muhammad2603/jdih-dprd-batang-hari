<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\FrontendConfig;
use App\Models\FaqModel;

class Faq extends BaseController
{
    private $fe_config_model;
    private $faq_model;
    public function __construct()
    {
        $this->fe_config_model  = new FrontendConfig;
        $this->faq_model        = new FaqModel;
    }
    public function index()
    {
        $data_feconfig = $this->fe_config_model->getAllData();
        $faq_by_category = $this->request->getGet("kategori") ?? false;
        $faq_by_keyword = $this->request->getGet("keyword") ?? false;
        $faq = $this->faq_model->getFaq([
            "field" => "judul",
            "sort" => "ASC"
        ], $faq_by_keyword, $faq_by_category);
        $page_title = "FAQ JDIH DPRD Kabupaten Batang Hari | Bantuan & Panduan Penggunaan";
        $page_alias = "FAQ";
        $page_description = "Temukan jawaban atas pertanyaan umum seputar JDIH DPRD Kabupaten Batang Hari, mulai dari penggunaan sistem, bantuan layanan, hingga informasi teknis terkait akses dan pencarian dokumen hukum daerah.";
        $page_keywords = [
            "FAQ JDIH DPRD Batang Hari",
            "Bantuan JDIH",
            "Panduan Penggunaan JDIH",
            "FAQ Dokumentasi Hukum",
            "Informasi Hukum Daerah",
            "Bantuan Teknis JDIH",
            "Pusat Bantuan JDIH",
            "Tanya Jawab JDIH",
            "JDIH Kabupaten Batang Hari",
            "Sistem Informasi Hukum DPRD",
        ];
        $other_meta = [
            "faq_list"      => $faq,
            "by_category"   => $faq_by_category,
        ];
        $page_data = create_page_meta(
            $page_title,
            $page_alias,
            $page_description,
            $page_keywords,
            $data_feconfig,
            $other_meta
        );
        return view('pages/faq', $page_data);
    }
}
