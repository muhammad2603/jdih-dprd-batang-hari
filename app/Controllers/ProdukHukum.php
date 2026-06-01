<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\FrontendConfig;
use App\Models\DocumentCategories;

helper('pagination');
class ProdukHukum extends BaseController
{
    private $frontend_config_model;
    private $produk_hukum_model;
    private $document_categories_model;
    public function __construct()
    {
        $this->frontend_config_model        = new FrontendConfig;
        $this->produk_hukum_model           = new \App\Models\ProdukHukum;
        $this->document_categories_model    = new DocumentCategories;
    }
    public function index()
    {
        $get_page = $this->request->getVar('page') ?? 1;
        $keyword = $this->request->getVar('keyword') ?? false;
        $category = $this->request->getVar('category') ?? false;
        $year = $this->request->getVar('year') ?? false;
        $status = $this->request->getVar('status') ?? false;
        $data_per_page = 10;
        $total_produk_hukum = $this->produk_hukum_model->getTotalProdukHukumHighlight($keyword, $category, $year, $status);
        [
            "page" => $current_page,
            "offset" => $data_offset,
            "data_index" => $data_index,
            "pager" => $mk_pager
        ] = create_pagination($get_page, $data_per_page, $total_produk_hukum);
        $produk_hukum = $this->produk_hukum_model->getProdukHukumHighlight($data_per_page, $data_offset, $keyword, $category, $year, $status);
        $getYearsDocumentUploaded = $this->produk_hukum_model->getYearsDocumentUploaded();
        $getDocumentCategories = $this->document_categories_model->getDocumentCategories();
        $data_feconfig = $this->frontend_config_model->getAllData();
        $page_title = "Produk Hukum | JDIH DPRD Kabupaten Batang Hari";
        $page_alias = "Produk Hukum";
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
            "current_keyword" => $keyword,
            "current_category" => $category,
            "current_year" => $year,
            "years_option_select" => $getYearsDocumentUploaded,
            "document_categories" => $getDocumentCategories,
        ];
        $page_data = create_page_meta(
            $page_title,
            $page_alias,
            $page_description,
            $page_keywords,
            $data_feconfig,
            $other_meta
        );
        return view("pages/produk_hukum", $page_data);
    }
}
