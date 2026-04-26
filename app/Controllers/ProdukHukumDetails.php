<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

helper('string');

class ProdukHukumDetails extends BaseController
{
    private $fe_config_model;
    private $ph_model;
    private $riwayat_perubahan_ph_model;
    public function __construct()
    {
        $this->fe_config_model              = model("FrontendConfig");
        $this->ph_model                     = model("ProdukHukum");
        $this->riwayat_perubahan_ph_model   = model("RiwayatPerubahanProdukHukum");
    }
    public function index(...$segments)
    {
        [$category, $slug] = $segments;
        $category = uri_title_to_words($category);
        $allowed_categories = [
            "Peraturan Bupati"
        ];
        if (!in_array($category, $allowed_categories))
            return $this->response->setStatusCode(400)->setJSON(["status" => 400, "message" => "Kategori produk hukum tidak terdaftar atau tidak diizinkan!"]);
        $data_feconfig = $this->fe_config_model->getAllData();
        $page_alias = "Produk Hukum";
        $page_description = "Deskripsi halaman";
        $page_keywords = [
            "Statistik"
        ];
        $produk_hukum = $this->ph_model->getProdukHukumDetails($slug, $category);
        $ph_id = intval($produk_hukum["id"]);
        $histories_change = $this->riwayat_perubahan_ph_model->getHistoriesChange($ph_id);
        $page_title = $produk_hukum["judul"] . " | Produk Hukum";
        $other_meta = [
            "produk_hukum" => $produk_hukum,
            "histories_change" => $histories_change
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
