<?php

namespace App\Controllers;

use App\Models\FrontendConfig;
use App\Models\ProdukHukum;

class Home extends BaseController
{
    private $frontend_config;
    private $produk_hukum;
    public function __construct()
    {
        $this->frontend_config = new FrontendConfig;
        $this->produk_hukum = new ProdukHukum;
    }
    public function index(): string
    {
        $data_feconfig = $this->frontend_config->getAllData();
        $get_all_new_document = $this->produk_hukum->getProdukHukumHighlight();
        $get_years_document_uploaded = $this->produk_hukum->getYearsDocumentUploaded();
        $page_title = "Layanan JDIH DPRD Kabupaten Batang Hari";
        $page_alias = "Beranda";
        $page_description = "Website resmi JDIH DPRD Kabupaten Batang Hari untuk publikasi dokumen hukum daerah.";
        $page_keywords = ['JDIH', 'DPRD Batang Hari', 'Layanan DPRD Batang Hari', 'Informasi Dokumen Hukum'];
        $other_meta = [
            "new_documents"                     => $get_all_new_document,
            "total_produk_hukum"                => $this->produk_hukum->getTotalProdukHukumHighlight(),
            "total_produk_hukum_by_category"    => $this->produk_hukum->getTotalDocumentByCategory(),
            "total_pengunjung"                  => model("Pengunjung")->totalVisitor(),
            "years_document_uploaded"           => $get_years_document_uploaded,
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
