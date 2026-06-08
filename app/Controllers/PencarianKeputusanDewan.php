<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\FrontendConfig;
use App\Models\ProdukHukum;

helper("pagination");

class PencarianKeputusanDewan extends BaseController
{
    private $fe_config_model;
    private $ph_model;
    public function __construct()
    {
        $this->fe_config_model  = new FrontendConfig;
        $this->ph_model         = new ProdukHukum;
    }
    public function index()
    {
        $data_feconfig = $this->fe_config_model->getAllData();
        $current_page = $this->request->getVar("page") ?? 1;
        $get_keyword = $this->request->getVar("keyword") ?? false;
        $get_year = $this->request->getVar("year") ?? false;
        $data_per_page = 10;
        $category_id = 5; // Keputusan Dewan
        $total_dokumen_keputusan_dewan = $this->ph_model->getTotalProdukHukumHighlight($get_keyword, $category_id, $get_year);
        [
            "page"          => $page,
            "offset"        => $offet,
            "data_index"    => $data_index,
            "pager"         => $pager,
        ] = create_pagination($current_page, $data_per_page, $total_dokumen_keputusan_dewan);
        $get_dokumen_keputusan_dewan = $this->ph_model->getProdukHukumHighlight($data_per_page, $offet, $get_keyword, $category_id, $get_year);
        $page_title = "Peraturan Keputusan DPRD Batang Hari | JDIH DPRD Kabupaten Batang Hari";
        $page_alias = "Peraturan Keputusan Dewan";
        $page_description = "Temukan Peraturan Keputusan Dewan DPRD Kabupaten Batang Hari melalui layanan pencarian dokumen hukum JDIH. Akses informasi keputusan dewan, dokumentasi hukum daerah, dan arsip peraturan secara mudah dan cepat.";
        $page_keywords = [
            "Peraturan Keputusan Dewan",
            "Keputusan Dewan DPRD",
            "JDIH DPRD Kabupaten Batang Hari",
            "Dokumentasi Hukum DPRD",
            "Produk Hukum Dewan",
            "Arsip Keputusan Dewan",
            "Informasi Hukum Daerah",
            "Pencarian Dokumen Hukum",
            "JDIH Kabupaten Batang Hari",
            "Keputusan Anggota DPRD",
        ];
        $get_years_product_law = $this->ph_model->getYearsProductLaw();
        $other_meta = [
            "dokumen"                   => $get_dokumen_keputusan_dewan,
            "pager_links"               => $total_dokumen_keputusan_dewan > $data_per_page ? $pager : false,
            "total_dokumen"             => $total_dokumen_keputusan_dewan,
            "data_display_count"        => $data_index,
            "current_search"            => $get_keyword,
            "current_selected_year"     => $get_year,
            "years_product_law"         => $get_years_product_law,
        ];
        $page_data = create_page_meta(
            $page_title,
            $page_alias,
            $page_description,
            $page_keywords,
            $data_feconfig,
            $other_meta
        );
        return view('pages/pencarian_keputusan_dewan', $page_data);
    }
}
