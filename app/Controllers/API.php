<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProdukHukum;

class API extends BaseController
{
    private ProdukHukum $produk_hukum_model;
    public function __construct()
    {
        $this->produk_hukum_model = new ProdukHukum;
    }
    public function searchDocument()
    {
        if (!$this->request->isAJAX()) {
            return $this->response
                ->setHeader("Content-Type", 'application/json')
                ->setStatusCode(400)
                ->setJSON([
                    "message" => "AJAX dibutuhkan untuk mengakses sumber ini."
                ]);
        }
        $keyword    = $this->request->getVar('judul') ?? false;
        $type       = $this->request->getVar('jenis') ?? false;
        $tahun      = $this->request->getVar('tahun') ?? false;
        $status     = $this->request->getVar('status') ?? false;
        $perPage    = 8;
        $offset     = 0;
        $produk_hukum_highlight                 = $this->produk_hukum_model->getProdukHukumHighlight($perPage, $offset, $keyword, $type, $tahun, $status);
        $total_produk_hukum_highlight_found     = $this->produk_hukum_model->getTotalProdukHukumHighlight($keyword, $type, $tahun, $status);
        return $this->response
            ->setHeader("Content-Type", 'application/json')
            ->setJSON([
                "message" => "Data berhasil didapatkan.",
                "total" => $total_produk_hukum_highlight_found,
                "view" => view('dashboard/layouts/table_list_produk_hukum', ["produk_hukum" => $produk_hukum_highlight])
            ]);
    }
}
