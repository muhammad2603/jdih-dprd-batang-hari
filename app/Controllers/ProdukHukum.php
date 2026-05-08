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
        // TODO buat helper atau library untuk membuat pagination otomatis
        $pager = service("pager");
        $get_page = $this->request->getVar('page');
        $current_page = is_numeric($get_page) ? (int) $get_page : 1;
        $data_per_page = 10;
        $data_offset = ($current_page - 1) * $data_per_page;
        $produk_hukum = $this->produk_hukum_model->getProdukHukumHighlight($data_per_page, $data_offset);
        $total_produk_hukum = $this->produk_hukum_model->getTotalProdukHukumHighlight();
        $mk_pager = $pager->makeLinks($current_page, $data_per_page, $total_produk_hukum, "modern", 0);
        $data_index = (($data_offset + 1) !== $total_produk_hukum) && ($total_produk_hukum > $data_per_page) ? ($data_offset + 1) . " - " . ($current_page * $data_per_page) : $total_produk_hukum;
        $data_feconfig = $this->frontend_config_model->getAllData();
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
            "paginate" => $produk_hukum,
            "pager_links" => $mk_pager,
            "current_page" => $current_page,
            "data_per_page" => $data_per_page,
            "data_index" => $data_index,
            "total_produk_hukum" => $total_produk_hukum,
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
