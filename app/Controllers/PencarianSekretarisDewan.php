<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\FrontendConfig;
use App\Models\ProdukHukum;

helper('pagination');

class PencarianSekretarisDewan extends BaseController
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
        $per_page = 10;
        $by_keyword = $this->request->getVar("keyword") ?? false;
        $by_year = $this->request->getVar("year") ?? false;
        $by_category = 2; // 2 -> Sekretaris Dewan
        $total_produk_hukum_keputusan_sekwan = $this->ph_model->getTotalProdukHukumHighlight($by_keyword, $by_category, $by_year);
        [
            "page" => $current_page,
            "offset" => $data_offset,
            "data_index" => $data_index,
            "pager" => $mk_pager
        ] = create_pagination($current_page, $per_page, $total_produk_hukum_keputusan_sekwan);
        $produk_hukum_keputusan_sekwan = $this->ph_model->getProdukHukumHighlight($per_page, $data_offset, $by_keyword, $by_category, $by_year);
        $page_title = "Peraturan Sekretaris Dewan | JDIH DPRD Kabupaten Batang Hari";
        $page_alias = "Peraturan Sekretaris Dewan";
        $page_description = "Temukan Peraturan Sekretaris Dewan DPRD Kabupaten Batang Hari melalui layanan JDIH secara cepat, mudah, dan transparan. Akses arsip peraturan Sekretariat Dewan serta dokumentasi hukum resmi daerah yang selalu diperbarui.";
        $page_keywords = [
            "Peraturan Sekretaris Dewan",
            "Peraturan Sekwan",
            "JDIH DPRD Kabupaten Batang Hari",
            "Dokumentasi Hukum Daerah",
            "Produk Hukum Sekretariat DPRD",
            "Arsip Peraturan Sekretaris Dewan",
            "Informasi Hukum Daerah",
            "Pencarian Dokumen Hukum",
            "JDIH Kabupaten Batang Hari",
            "Regulasi Sekretariat DPRD Batang Hari",
        ];
        $other_meta = [
            "dokumen_keputusan_sekwan"  => $produk_hukum_keputusan_sekwan,
            "pager_links"               => $total_produk_hukum_keputusan_sekwan > $per_page ? $mk_pager : false,
            "total_dokumen"             => $total_produk_hukum_keputusan_sekwan,
            "data_display_count"        => $data_index,
            "current_search"            => $by_keyword,
            "current_selected_year"     => $by_year,
            "years_document_uploaded"   => $this->ph_model->getYearsDocumentUploaded($by_category),
        ];
        $page_data = create_page_meta(
            $page_title,
            $page_alias,
            $page_description,
            $page_keywords,
            $data_feconfig,
            $other_meta
        );
        return view('pages/pencarian_peraturan_sekretaris_dewan', $page_data);
    }
}
