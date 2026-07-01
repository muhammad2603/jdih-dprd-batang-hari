<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProdukHukum;

helper("pagination");

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
        $current_page   = $this->request->getVar('page') ?? 1;
        $keyword        = $this->request->getVar('judul') ?? false;
        $type           = $this->request->getVar('jenis') ?? false;
        $tahun          = $this->request->getVar('tahun') ?? false;
        $status         = $this->request->getVar('status') ?? false;
        $data_per_page  = 8;
        $total_produk_hukum_highlight_found = $this->produk_hukum_model->getTotalProdukHukumHighlight($keyword, $type, $tahun, $status);
        [
            "page" => $current_page,
            "offset" => $data_offset,
            "data_index" => $data_index,
            "pager" => $mk_pager
        ] = create_pagination($current_page, $data_per_page, $total_produk_hukum_highlight_found, false, "modern_dynamic");
        $produk_hukum_highlight = $this->produk_hukum_model->getProdukHukumHighlight($data_per_page, $data_offset, $keyword, $type, $tahun, $status);
        return $this->response
            ->setHeader("Content-Type", 'application/json')
            ->setJSON([
                "message" => "Data berhasil didapatkan.",
                "total" => $total_produk_hukum_highlight_found,
                "data_index" => ($total_produk_hukum_highlight_found !== 0) ? "Menampilkan $data_index dari $total_produk_hukum_highlight_found dokumen yang tersedia" : "",
                "view" => [
                    "produk_hukum" => view('dashboard/layouts/table_list_produk_hukum', [
                        "produk_hukum" => $produk_hukum_highlight,
                        "page" => $current_page,
                        "data_offset" => $data_offset
                    ]),
                    "pager" => ($total_produk_hukum_highlight_found > $data_per_page) ? $mk_pager : "",
                ],
            ]);
    }
}
