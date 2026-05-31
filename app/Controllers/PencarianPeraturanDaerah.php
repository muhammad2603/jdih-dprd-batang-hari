<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\FrontendConfig;
use App\Models\ProdukHukum;

helper("pagination");

class PencarianPeraturanDaerah extends BaseController
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
        $by_category = 1; // 1 -> PerDa (Peraturan Daerah)
        $total_produk_hukum_perda = $this->ph_model->getTotalProdukHukumHighlight($by_keyword, $by_category, $by_year);
        [
            "page" => $current_page,
            "offset" => $data_offset,
            "data_index" => $data_index,
            "pager" => $mk_pager
        ] = create_pagination($current_page, $per_page, $total_produk_hukum_perda);
        $produk_hukum_perda = $this->ph_model->getProdukHukumHighlight($per_page, $data_offset, $by_keyword, $by_category, $by_year);
        $page_title = "Pencarian Peraturan Daerah";
        $page_description = "Deskripsi halaman";
        $page_keywords = [
            "Statistik"
        ];
        $other_meta = [
            "dokumen_perda"             => $produk_hukum_perda,
            "pager_links"               => $total_produk_hukum_perda > $per_page ? $mk_pager : false,
            "total_dokumen"             => $total_produk_hukum_perda,
            "data_display_count"        => $data_index,
            "current_search"            => $by_keyword,
            "current_selected_year"     => $by_year,
            "years_document_uploaded"   => $this->ph_model->getYearsDocumentUploaded($by_category),
        ];
        $page_data = create_page_meta(
            $page_title,
            $page_title,
            $page_description,
            $page_keywords,
            $data_feconfig,
            $other_meta
        );
        return view('pages/pencarian_peraturan_daerah', $page_data);
    }
}
