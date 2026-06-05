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
        $this->response->setHeader("ContentType", 'application/json');

        // Selected fields
        $fields = [
            "ph.id AS idData",
            "YEAR(ph.tanggal_pengundangan) AS tahun_pengundangan",
            "ph.tanggal_penetapan",
            "ph.tanggal_pengundangan",
            "UPPER(doc_categs.category) AS jenis",
            "ph.nomor AS noPeraturan",
            "ph.title AS judul",
            "UPPER(doc_categs.category_synonym) AS singkatanJenis",
            "'Indonesia' AS tempatTerbit",
            "CONCAT(sph.akronim, ': ', mph.jumlah_halaman, ' hlm') AS sumber",
            "doc_status.status",
            "mph.bahasa",
            "GROUP_CONCAT(kbh.kategori SEPARATOR ', ') AS bidangHukum",
            "ph.tajuk_entri_utama AS teuBadan",
            "ph.updated_at AS last_updated",
            "CONCAT('" . base_url() . "', 'assets/abstrak/', mph.abstrak_pdf) AS urlAbstrak",
            "CONCAT('" . base_url() . "', 'produk-hukum/', REPLACE(LOWER(doc_categs.category), ' ', '-'), '/', ph.slug) AS urlDetailPeraturan",
            // __COMMENT__ selalu pantau field dibawah ini didokumentasi JDIHN BPHN, karena mereka akan meminta field ini diupdate mendatang
            "'-' AS fileDownload",
            "'-' AS urlDownload",
            "'' AS subjek",
            "'4' AS operasi",
            "'1' AS display",
        ];

        // Ambil produk hukum
        $produk_hukum = (\Config\Database::connect())
            ->table("produk_hukum ph")
            ->select($fields)
            ->join("meta_produk_hukum mph", 'mph.ph_id = ph.id', 'inner')
            ->join("document_categories doc_categs", 'doc_categs.id = ph.category_id', 'inner')
            ->join("document_status doc_status", 'doc_status.id = ph.status_id')
            ->join("sumber_produk_hukum sph", 'sph.id = mph.sumber_id')
            ->join("klasifikasi_bidang_hukum klf_bh", 'klf_bh.ph_id = ph.id')
            ->join("kategori_bidang_hukum kbh", 'kbh.id = klf_bh.bidang_hukum_id')
            ->where("ph.is_publish", true)
            ->groupBy('ph.id')
            ->get()->getResultArray();

        $data = [
            ...$produk_hukum
        ];
        return $this->response->setJSON($data);
    }
}
