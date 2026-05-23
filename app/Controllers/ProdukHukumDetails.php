<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\FrontendConfig;
use App\Models\ProdukHukum;
use App\Models\RiwayatPerubahanProdukHukum;

helper('string');

class ProdukHukumDetails extends BaseController
{
    private $fe_config_model;
    private $ph_model;
    private $riwayat_perubahan_ph_model;
    public function __construct()
    {
        $this->fe_config_model              = new FrontendConfig;
        $this->ph_model                     = new ProdukHukum;
        $this->riwayat_perubahan_ph_model   = new RiwayatPerubahanProdukHukum;
    }
    public function index(...$segments)
    {
        [$category, $slug] = $segments;
        $category = uri_title_to_words($category);
        $data_feconfig = $this->fe_config_model->getAllData();
        $page_alias = "Produk Hukum";
        $page_description = "Deskripsi halaman";
        $page_keywords = [
            "Statistik"
        ];
        $produk_hukum = $this->ph_model->getProdukHukumDetails($slug, $category);
        $ph_id = intval($produk_hukum["id"]);
        $classify_produk_hukum = $this->ph_model->getClassifyProdukHukum($ph_id);
        $histories_change = $this->riwayat_perubahan_ph_model->getHistoriesChange($ph_id);
        $relatedDocuments = $this->ph_model->getRelatedDocuments($ph_id);
        $page_title = $produk_hukum["judul"] . " | Produk Hukum";
        $other_meta = [
            "produk_hukum"      => $produk_hukum,
            "histories_change"  => $histories_change,
            "bidang_hukum"      => explode(", ", $classify_produk_hukum["bidang_hukum"]),
            "subjek"            => $classify_produk_hukum["subjek"],
            "related_documents" => $relatedDocuments
        ];
        $page_data = create_page_meta(
            $page_title,
            $page_alias,
            $page_description,
            $page_keywords,
            $data_feconfig,
            $other_meta
        );
        return view('pages/produk_hukum_details', $page_data);
    }
}
