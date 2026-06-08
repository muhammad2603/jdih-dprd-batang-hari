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
        $get_years_product_law = $this->produk_hukum->getYearsProductLaw();
        $get_document_status = $this->document_status_model->getStatus();
        $total_produk_hukum = $this->produk_hukum->getTotalProdukHukumHighlight();
        $get_document_categories = $this->produk_hukum->getTotalDocumentByCategory();
        $page_title = "JDIH DPRD Kabupaten Batang Hari | Dokumentasi & Informasi Hukum Daerah";
        $page_alias = "Beranda";
        $page_description = "Portal resmi JDIH DPRD Kabupaten Batang Hari untuk akses dokumentasi dan informasi hukum daerah. Jelajahi produk hukum terbaru, pencarian dokumen cepat, statistik layanan hukum, dan kategori peraturan secara lengkap dan transparan.";
        $page_keywords = [
            "JDIH DPRD Kabupaten Batang Hari",
            "Dokumentasi Hukum Daerah",
            "Informasi Hukum Daerah",
            "Produk Hukum DPRD",
            "Peraturan Daerah",
            "Keputusan DPRD",
            "JDIH Kabupaten Batang Hari",
            "Pusat Dokumentasi Hukum",
            "Statistik Dokumen Hukum",
            "Pencarian Produk Hukum",
            "Transparansi Informasi Publik",
            "JDIH Provinsi Jambi",
            "Produk Hukum Terbaru",
        ];
        $get_meta_page = $this->pages_meta_model->getMetaPagesByIdentity("Beranda");
        $other_meta = [
            "meta_page"                         => $get_meta_page,
            "new_documents"                     => $get_all_new_document,
            "total_produk_hukum"                => $total_produk_hukum,
            "total_pengunjung"                  => model("Pengunjung")->totalVisitor(),
            "years_product_law"                 => $get_years_product_law,
            "document_categories"               => $get_document_categories,
            "total_categories"                  => count($get_document_categories),
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
