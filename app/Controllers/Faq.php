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
        $page_title = "FAQ";
        $page_description = "Deskripsi halaman";
        $page_keywords = [
            "Statistik"
        ];
        $other_meta = [
            "faq_list"      => $faq,
            "by_category"   => $faq_by_category,
        ];
        $page_data = create_page_meta(
            $page_title,
            $page_title,
            $page_description,
            $page_keywords,
            $data_feconfig,
            $other_meta
        );
        return view('pages/faq', $page_data);
    }
}
