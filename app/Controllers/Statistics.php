<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Database;
use App\Models\FrontendConfig;
use App\Models\ProdukHukum;

class Statistics extends BaseController
{
    private $fe_config_model;
    private $produk_hukum_model;
    public function __construct()
    {
        $this->fe_config_model      = new FrontendConfig;
        $this->produk_hukum_model   = new ProdukHukum();
    }
    public function index()
    {
        (Database::connect())->query("SET lc_time_names = 'id_ID'");
        $data_feconfig = $this->fe_config_model->getAllData();
        $page_title = "Statistik JDIH Kabupaten Batang Hari";
        $page_alias = "Statistik";
        $page_description = "Statistik JDIH DPRD Kabupaten Batang Hari yang menampilkan data produk hukum daerah, jumlah dokumen, distribusi kategori peraturan, tren publikasi, dan total unduhan dokumen hukum secara transparan.";
        $page_keywords = [
            "JDIH",
            "JDIH DPRD Kabupaten Batang Hari",
            "Statistik JDIH",
            "Statistik Dokumen DPRD",
            "Statistik JDIH DPRD Kabupaten Batang Hari",
            "Statistik Produk Hukum Batang Hari",
            "Grafik Dokumen Hukum",
            "Visualisasi Produk Hukum Daerah"
        ];
        $other_meta = [
            "total_produk_hukum"                            => (int) $this->produk_hukum_model->getTotalDocument()["total"],
            "total_produk_hukum_current_month"              => $this->produk_hukum_model->getTotalDocumentByMonth(date("m", time())),
            "total_produk_hukum_current_year"               => $this->produk_hukum_model->getTotalDocumentByYear(date("Y", time())),
            "total_doc_by_year"                             => $this->produk_hukum_model->getTotalDocumentPerYears()["result"],
            "total_doc_by_categories"                       => $this->produk_hukum_model->getTotalDocByCategories()["result"],
            "total_doc_by_months_on_current_year"           => $this->produk_hukum_model->getTotalDocPerMonths()["result"],
        ];
        $page_data = create_page_meta(
            $page_title,
            $page_alias,
            $page_description,
            $page_keywords,
            $data_feconfig,
            $other_meta
        );
        return view("pages/statistics", $page_data);
    }
}
