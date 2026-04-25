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
        $page_title = "Syarat & Ketentuan";
        $page_description = "Deskripsi halaman";
        $page_keywords = [
            "Statistik"
        ];
        $other_meta = [];
        $page_data = create_page_meta(
            $page_title,
            $page_title,
            $page_description,
            $page_keywords,
            $data_feconfig,
            $other_meta
        );
        return view('pages/syarat_ketentuan', $page_data);
    }
}
