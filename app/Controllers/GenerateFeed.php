<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProdukHukum;

class GenerateFeed extends BaseController
{
    private $ph_model;

    public function __construct()
    {
        $this->ph_model = new ProdukHukum;
    }

    public function view()
    {
        $abstract_url = base_url() . 'assets/abstrak/';
        $produk_hukum_url = base_url() . 'produk-hukum/';
        $fields = [
            "ph.id AS idData",
            "YEAR(ph.tanggal_pengundangan) AS tahun_pengundangan",
            "ph.tanggal_penetapan",
            "ph.tanggal_pengundangan",
            "UPPER(doc_categs.category) AS jenis",
            "ph.nomor AS noPeraturan",
            "ph.title AS judul",
            "CASE
                WHEN doc_categs.category_synonym IS NULL THEN ''
                ELSE UPPER(doc_categs.category_synonym)
            END AS singkatanJenis",
            "'Indonesia' AS tempatTerbit",
            "CONCAT(sph.akronim, ': ', mph.jumlah_halaman, ' hlm') AS sumber",
            "doc_status.status",
            "mph.bahasa",
            "CASE
                WHEN kbh.kategori IS NULL THEN ''
                ELSE GROUP_CONCAT(kbh.kategori SEPARATOR ', ')
            END AS bidangHukum",
            "pjb.nama AS teuBadan",
            "CASE
                WHEN ph.updated_at IS NULL THEN ''
                ELSE ph.updated_at
            END AS last_updated",
            "CASE
                WHEN mph.abstrak_pdf IS NULL THEN ''
                ELSE CONCAT('$abstract_url', mph.abstrak_pdf)
            END AS urlAbstrak",
            "CONCAT('$produk_hukum_url', REPLACE(LOWER(doc_categs.category), ' ', '-'), '/', ph.slug) AS urlDetailPeraturan",
            // __COMMENT__ selalu pantau field dibawah ini didokumentasi JDIHN BPHN, karena mereka akan meminta field ini diupdate mendatang
            "'-' AS fileDownload",
            "'-' AS urlDownload",
            "'' AS subjek",
            "'4' AS operasi",
            "'1' AS display",
        ];
        $produk_hukum = $this->ph_model->getProdukHukumFeed($fields);
        $max_time_cache = 3 * (60 * 60);
        return $this->response
            ->setHeader("Content-Type", 'application/json')
            ->setHeader("Cache-Control", "public, max-age=$max_time_cache")
            ->setJSON($produk_hukum);
    }
}
