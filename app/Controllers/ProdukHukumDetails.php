<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\FrontendConfig;
use App\Models\ProdukHukum;
use App\Models\RiwayatPerubahanProdukHukum;

helper(['string', 'document_attributes']);

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
        $document = $this->ph_model->getProdukHukumDetails($slug, $category);
        if (!$document) {
            return redirect()->to('/produk-hukum');
        }
        $ph_id = intval($document["id"]);
        $classify_document = $this->ph_model->getClassifyProdukHukum($ph_id);
        $histories_change = $this->riwayat_perubahan_ph_model->getHistoriesChange($ph_id);
        $related_documents = $this->ph_model->getRelatedDocuments($ph_id);
        $document_title = esc($document["judul"]);
        $document_category = esc($document["kategori"]);
        $status_document_colors = status_document_colors();
        $page_title = $document_title . " | JDIH DPRD Kabupaten Batang Hari";
        $page_alias = "Produk Hukum";
        $autofill_category = str_starts_with($document_category, "Peraturan") ? $document_category : "Peraturan " . $document_category;
        $page_description = "Akses dokumen hukum " . $autofill_category . " dengan judul " . $document_title . " Nomor " . esc($document['nomor']) . " Tahun " . esc($document['tahun']) . " Kabupaten Batang Hari. Unduh dokumen resmi dan informasi hukum daerah melalui JDIH DPRD Kabupaten Batang Hari.";
        $page_keywords = [
            $document_title,
            $autofill_category,
            $autofill_category . " Kabupaten Batang Hari",
            "JDIH DPRD Kabupaten Batang Hari",
            "Dokumen Hukum Daerah",
            "Produk Hukum",
            "Peraturan Daerah Batang Hari",
            "Arsip Hukum Resmi",
        ];
        $other_meta = [
            "produk_hukum"      => $document,
            "histories_change"  => $histories_change,
            "bidang_hukum"      => explode(", ", $classify_document["bidang_hukum"]),
            "subjek"            => $classify_document["subjek"],
            "related_documents" => $related_documents,
            "status_document_colors" => $status_document_colors
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
