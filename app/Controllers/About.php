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
        $page_title = "Tentang";
        $page_description = "Deskripsi halaman";
        $page_keywords = [
            "Tentang JDIH DPRD Batang Hari",
            "Kabupaten Batang Hari",
            "DPRD Batang Hari"
        ];
        $other_meta = [
            "page_meta" => $this->pages_meta_model->getMetaPagesByIdentity("Tentang"),
        ];
        $page_data = create_page_meta(
            $page_title,
            $page_title,
            $page_description,
            $page_keywords,
            $data_feconfig,
            $other_meta
        );
        return view('pages/about', $page_data);
    }
}
