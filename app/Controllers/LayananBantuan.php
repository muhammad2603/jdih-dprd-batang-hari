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
    public function __construct()
    {
        $this->fe_config_model  = new FrontendConfig;
        $this->pages_meta_model = new PagesMeta;
    }
    public function index()
    {
        $data_feconfig = $this->fe_config_model->getAllData();
        $page_title = "Pusat Bantuan";
        $page_description = "Deskripsi halaman";
        $page_keywords = [
            "Statistik"
        ];
        $other_meta = [
            "pages_meta" => $this->pages_meta_model->getMetaPagesByIdentity("Bantuan"),
        ];
        $page_data = create_page_meta(
            $page_title,
            $page_title,
            $page_description,
            $page_keywords,
            $data_feconfig,
            $other_meta
        );
        return view('pages/bantuan', $page_data);
    }
}
