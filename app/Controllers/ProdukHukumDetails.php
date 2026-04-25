<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProdukHukum;
use App\Models\FrontendConfig;

class ProdukHukumDetails extends BaseController
{
    private $fe_config_model;
    public function __construct()
    {
        $this->fe_config_model = new FrontendConfig;
    }
    public function index(...$segments)
    {
        [$category, $slug] = $segments;
        // TODO Buat helper untuk menghapus strip pada kategori sekaligus mengubah huruf disetiap kata menjadi kapital
        $remove_strip_category = str_replace("-", " ", $category);
        $setCapitalFirstWord = ucwords($remove_strip_category, " ");

        $allowed_categories = [
            "Peraturan Bupati"
        ];
        if (!in_array($setCapitalFirstWord, $allowed_categories))
            return $this->response->setStatusCode(400)->setJSON(["status" => 400, "message" => "Kategori produk hukum tidak terdaftar atau tidak diizinkan!"]);

        $produk_hukum = (new ProdukHukum)->getProdukHukumDetails($slug, $setCapitalFirstWord);

        $data_feconfig = $this->fe_config_model->getAllData();
        $page_title = "[Judul Dokumen] | Produk Hukum";
        $page_alias = "Produk Hukum";
        $page_description = "Deskripsi halaman";
        $page_keywords = [
            "Statistik"
        ];
        $other_meta = [];
        $page_data = create_page_meta(
            $page_title,
            $page_alias,
            $page_description,
            $page_keywords,
            $data_feconfig,
            $other_meta
        );
        return view('pages/produk_hukum_details', $page_data);

        dd([
            "kategori"  => $category,
            "slug"      => $slug,
            "result"    => $produk_hukum
        ]);
    }
}
