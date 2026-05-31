<?php

namespace App\Controllers;

use App\Models\DocumentStatus;
use App\Models\FrontendConfig;
use App\Models\ProdukHukum;
use App\Models\PagesMeta;

class Home extends BaseController
{
    private $frontend_config;
    private $produk_hukum;
    private $document_status_model;
    private $pages_meta_model;
    public function __construct()
    {
        $this->frontend_config           = new FrontendConfig;
        $this->produk_hukum              = new ProdukHukum;
        $this->document_status_model     = new DocumentStatus;
        $this->pages_meta_model          = new PagesMeta;
    }
    public function index(): string
    {
        $data_feconfig = $this->frontend_config->getAllData();
        $get_all_new_document = $this->produk_hukum->getProdukHukumHighlight();
        $get_years_document_uploaded = $this->produk_hukum->getYearsDocumentUploaded();
        $get_document_status = $this->document_status_model->getStatus();
        $get_document_categories = $this->produk_hukum->getTotalDocumentByCategory();
        $page_title = "Layanan JDIH DPRD Kabupaten Batang Hari";
        $page_alias = "Beranda";
        $page_description = "Website resmi JDIH DPRD Kabupaten Batang Hari untuk publikasi dokumen hukum daerah.";
        $page_keywords = ['JDIH', 'DPRD Batang Hari', 'Layanan DPRD Batang Hari', 'Informasi Dokumen Hukum'];
        $get_meta_page = $this->pages_meta_model->getMetaPagesByIdentity("Beranda");
        $other_meta = [
            "meta_page"                         => $get_meta_page,
            "new_documents"                     => $get_all_new_document,
            "total_produk_hukum"                => $this->produk_hukum->getTotalProdukHukumHighlight(),
            "total_pengunjung"                  => model("Pengunjung")->totalVisitor(),
            "years_document_uploaded"           => $get_years_document_uploaded,
            "document_categories"               => $get_document_categories,
            "document_status"                   => $get_document_status,
        ];
        $page_data = create_page_meta(
            $page_title,
            $page_alias,
            $page_description,
            $page_keywords,
            $data_feconfig,
            $other_meta
        );
        return view('home', $page_data);
    }
}
