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
        $get_all_data_feconfig = $this->frontend_config_model->getAllData();
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
        // TODO gunakan limit parameter di getProdukHukumHighlight saat ingin menerapkan pagination
        $get_produk_hukum_highlight = $this->produk_hukum_model->getProdukHukumHighlight();
        $page_data = [
            "page_title"        => 'Produk Hukum',
            "page_description"  => 'Database lengkap produk hukum daerah Kabupaten Batang Hari yang dapat diakses dan diunduh oleh publik, mencakup peraturan daerah, peraturan bupati, keputusan, dan dokumen hukum lainnya secara transparan dan terstruktur.',
            "page_keywords"     => $page_keywords,
            "page_author"       => 'DPRD Batang Hari',
            "frontend_config"   => array_group_by($get_all_data_feconfig, ["component", "category"]),
            "page_alias"        => 'Produk Hukum',
            "produk_hukum"      => $get_produk_hukum_highlight,
        ];
        return view("pages/produk_hukum", $page_data);
    }
}
