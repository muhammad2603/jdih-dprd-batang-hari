<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\FrontendConfig;

class ProdukHukum extends BaseController
{
    private $frontend_config_model;
    private $produk_hukum_model;

    public function __construct()
    {
        $this->frontend_config_model    = new FrontendConfig;
        $this->produk_hukum_model       = new \App\Models\ProdukHukum;
    }

    public function index()
    {
        $data_feconfig = $this->frontend_config_model->getAllData();
        // TODO gunakan limit parameter di getProdukHukumHighlight saat ingin menerapkan pagination
        $get_produk_hukum_highlight = $this->produk_hukum_model->getProdukHukumHighlight();
        $page_title = "Produk Hukum";
        $page_description = "Database lengkap produk hukum daerah Kabupaten Batang Hari yang dapat diakses dan diunduh oleh publik, mencakup peraturan daerah, peraturan bupati, keputusan, dan dokumen hukum lainnya secara transparan dan terstruktur.";
        $page_keywords = [
            "Produk Hukum Batang Hari",
            "JDIH Batang Hari",
            "Peraturan Daerah Batang Hari",
            "Peraturan Bupati Batang Hari",
            "Peraturan Bupati Batang Hari",
            "Keputusan DPRD Batang Hari",
            "Dokumen Hukum Daerah",
            "Database Hukum Daerah",
            "JDIH DPRD Batang Hari",
            "Informasi Hukum Publik",
            "Unduh Peraturan Daerah",
        ];
        $other_meta = [
            "produk_hukum"      => $get_produk_hukum_highlight,
        ];
        $page_data = create_page_meta(
            $page_title,
            $page_title,
            $page_description,
            $page_keywords,
            $data_feconfig,
            $other_meta
        );
        return view("pages/produk_hukum", $page_data);
    }
}
