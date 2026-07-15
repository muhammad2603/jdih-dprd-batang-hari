<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Database\BaseConnection;
use Config\Database;
use App\Models\ProdukHukum;
use App\Models\RelatedDocument;
use App\Models\DocumentCategories;
use App\Models\DocumentStatus;
use App\Models\Pejabat;
use App\Models\SumberProdukHukum;
use App\Models\LokasiProdukHukum;
use App\Models\KategoriBidangHukum;
use App\Models\KategoriSubjek;
use App\Models\DocumentStatusAction;
use App\Models\TipeRiwayatPerubahan;
use App\Models\RiwayatPerubahanProdukHukum;
use CodeIgniter\Shield\Entities\User;

class UserDashboard extends BaseController
{
    private BaseConnection $db;
    private ProdukHukum $produk_hukum_model;
    private RelatedDocument $related_document_model;
    private DocumentCategories $document_categories_model;
    private DocumentStatus $document_status_model;
    private Pejabat $pejabat_model;
    private LokasiProdukHukum $lokasi_produk_hukum_model;
    private SumberProdukHukum $sumber_produk_hukum_model;
    private KategoriBidangHukum $kategori_bidang_hukum_model;
    private KategoriSubjek $kategori_subjek_model;
    private DocumentStatusAction $document_status_action_model;
    private TipeRiwayatPerubahan $tipe_riwayat_perubahan_model;
    private RiwayatPerubahanProdukHukum $riwayat_perubahan_ph_model;
    private array $get_all_categories;
    private array $get_all_categories_only_view;
    private array $get_all_status;
    private array $get_pejabat;
    private array $get_all_location;
    private array $get_all_sumber;
    private array $get_all_action;
    private array $get_all_category_bidang_hukum;
    private array $get_all_category_subjek;
    private User $user;
    function __construct()
    {
        $this->db                               = Database::connect();
        $this->produk_hukum_model               = new ProdukHukum;
        $this->related_document_model           = new RelatedDocument;
        $this->document_categories_model        = new DocumentCategories;
        $this->document_status_model            = new DocumentStatus;
        $this->pejabat_model                    = new Pejabat;
        $this->lokasi_produk_hukum_model        = new LokasiProdukHukum;
        $this->sumber_produk_hukum_model        = new SumberProdukHukum;
        $this->kategori_bidang_hukum_model      = new KategoriBidangHukum;
        $this->kategori_subjek_model            = new KategoriSubjek;
        $this->document_status_action_model     = new DocumentStatusAction;
        $this->tipe_riwayat_perubahan_model     = new TipeRiwayatPerubahan;
        $this->riwayat_perubahan_ph_model       = new RiwayatPerubahanProdukHukum;
        $this->get_all_categories               = $this->document_categories_model->getAllDocumentCategories();
        $this->get_all_categories_only_view     = $this->document_categories_model->getDocumentCategories();
        $this->get_all_status                   = $this->document_status_model->getStatus();
        $this->get_pejabat                      = $this->pejabat_model->getPejabat();
        $this->get_all_location                 = $this->lokasi_produk_hukum_model->getLocation();
        $this->get_all_sumber                   = $this->sumber_produk_hukum_model->getSumber();
        $this->get_all_action                   = $this->document_status_action_model->getAction();
        $this->get_all_category_bidang_hukum    = $this->kategori_bidang_hukum_model->getKategoriBidangHukum();
        $this->get_all_category_subjek          = $this->kategori_subjek_model->getKategoriSubjek();
        $this->user                             = auth()->user();
    }
    protected function getTotalDocument(): int
    {
        return $this->produk_hukum_model->getTotalDocument()["total"];
    }
    protected function getTotalDocumentBerlaku(): int
    {
        return $this->produk_hukum_model->getTotalDocumentByStatus("Berlaku");
    }
    protected function getTotalRelatedDocumentIsAmmended(): int
    {
        return $this->produk_hukum_model->getTotalDocumentByStatus("Diubah");
    }
    protected function getTotalRelatedDocumentIsRevoked(): int
    {
        return $this->produk_hukum_model->getTotalDocumentByStatus("Dicabut");
    }
    public function home()
    {
        $total_document                         = $this->getTotalDocument();
        $total_document_berlaku                 = $this->getTotalDocumentBerlaku();
        $total_document_diubah                  = $this->getTotalRelatedDocumentIsAmmended();
        $total_document_dicabut                 = $this->getTotalRelatedDocumentIsRevoked();
        $curr_month                             = date('m');
        $total_document_current_month           =  $this->produk_hukum_model->getTotalDocumentByMonth($curr_month);
        $total_document_per_category            = $this->produk_hukum_model->getTotalDocumentByCategory();
        $percentage_of_berlaku_by_total_doc     = ($total_document_berlaku / $total_document) * 100;
        $meta_data = [
            "title" => 'Dashboard',
            "total_document" => $total_document,
            "total_document_berlaku" => $total_document_berlaku,
            "total_document_diubah" => $total_document_diubah,
            "total_document_dicabut" => $total_document_dicabut,
            "total_document_current_month" => $total_document_current_month,
            "percentage_berlaku_document" => $percentage_of_berlaku_by_total_doc,
            "total_document_per_category" => $total_document_per_category,
            "produk_hukum_highlight" => $this->produk_hukum_model->getProdukHukumHighlight(5),
        ];
        return view('dashboard/user/home', $meta_data);
    }
    public function manageDocuments()
    {
        $get_document_years = $this->produk_hukum_model->getYearsProductLaw('desc');
        $meta_page          = [
            "title"                 => 'Kelola Dokumen',
            "document_categories"   => $this->get_all_categories_only_view,
            "document_status"       => $this->get_all_status,
            "document_years"        => $get_document_years,
        ];
        return view('dashboard/user/manage_documents', $meta_page);
    }
    public function addDocument()
    {
        $role       = $this->user->getGroups()[0];
        $meta_page  = [
            "title" => 'Kelola Dokumen',
            "semua_kategori" => $this->get_all_categories,
            "kategori_utama" => $this->get_all_categories_only_view,
            "all_status" => $this->get_all_status,
            "pejabat" => $this->get_pejabat,
            "lokasi" => $this->get_all_location,
            "sumber" => $this->get_all_sumber,
            "document_actions" => $this->get_all_action,
            "kategori_bidang_hukum" => $this->get_all_category_bidang_hukum,
            "kategori_subjek" => $this->get_all_category_subjek,
            "role" => $role,
        ];
        return view('dashboard/user/add_document', $meta_page);
    }
    public function detailDocument(string $slug)
    {
        $slug                   = $slug ?? false;
        $produk_hukum_details   = $this->produk_hukum_model->getProdukHukumDetails($slug);
        if (!$produk_hukum_details) {
            return throw new \CodeIgniter\Exceptions\PageNotFoundException("Produk hukum yang anda cari tidak ditemukan.");
        }
        $ph_id                  = $produk_hukum_details["id"];
        $related_documents      = $this->produk_hukum_model->getRelatedDocuments($ph_id);
        $classifies_document    = $this->produk_hukum_model->getClassifyProdukHukum($ph_id);
        $meta_page              = [
            "title" => 'Kelola Dokumen',
            "produk_hukum" => $produk_hukum_details,
            "related_documents" => $related_documents,
            "bidang_hukum" => explode(', ', $classifies_document["bidang_hukum"]),
            "subjek" => $classifies_document["subjek"],
        ];
        return view('dashboard/user/details_document', $meta_page);
    }
    public function editDocument(string $slug)
    {
        $slug                       = $slug ?? false;
        $produk_hukum_details       = $this->produk_hukum_model->getProdukHukumDetails($slug);
        if (!$produk_hukum_details) {
            return throw new \CodeIgniter\Exceptions\PageNotFoundException("Produk hukum yang anda cari tidak ditemukan.");
        }
        $ph_id                      = $produk_hukum_details["id"];
        $related_documents          = $this->produk_hukum_model->getRelatedDocuments($ph_id);
        $tipe_perubahan             = $this->tipe_riwayat_perubahan_model->getTipePerubahan("Dibuat");
        // __COMMENT__ Tambahkan refactoring ini di next update, karena penggunaannya terlalu hard-coded
        $bidang_hukum = $this->db->table("klasifikasi_bidang_hukum kbh")
            ->select([
                "id",
                "kategori"
            ])
            ->where("ph_id", $ph_id)
            ->join("kategori_bidang_hukum kat_bh", 'kat_bh.id = kbh.bidang_hukum_id')->get()->getResultArray();
        $subjek = $this->db->table("klasifikasi_subjek ks")
            ->select([
                "id",
                "subjek"
            ])
            ->where("ph_id", $ph_id)
            ->join("kategori_subjek kat_sub", 'kat_sub.id = ks.subjek_id')->get()->getResultArray();
        $attachments = $this->db->table("lampiran_produk_hukum")
            ->select(["id", "judul_berkas", "nama_berkas"])
            ->where("ph_id", $ph_id)
            ->get()->getResultArray();
        $meta_page                  = [
            "title" => 'Kelola Dokumen',
            "produk_hukum" => $produk_hukum_details,
            "related_documents" => $related_documents,
            "kategori_bidang_hukum" => $this->get_all_category_bidang_hukum,
            "bidang_hukum" => $bidang_hukum,
            "kategori_subjek" => $this->get_all_category_subjek,
            "subjek" => $subjek,
            "document_actions" => $this->get_all_action,
            "document_categories" => $this->get_all_categories_only_view,
            "semua_kategori_dokumen" => $this->get_all_categories,
            "document_status" => $this->get_all_status,
            "pejabat" => $this->get_pejabat,
            "lokasi" => $this->get_all_location,
            "sumber" => $this->get_all_sumber,
            "tipe_perubahan" => $tipe_perubahan,
            "attachments" => $attachments
        ];
        return view('dashboard/user/edit_document', $meta_page);
    }
    public function statistic()
    {
        $total_document                 = $this->getTotalDocument();
        $total_document_active          = $this->getTotalDocumentBerlaku();
        $total_document_ammended        = $this->getTotalRelatedDocumentIsAmmended();
        $total_document_revoked         = $this->getTotalRelatedDocumentIsRevoked();
        $sq_ph = "SELECT
                category_id,
                COUNT(ph.id) AS total_dokumen,
                COUNT(CASE WHEN doc_status.status = 'Berlaku' THEN 1 END) AS total_dokumen_berlaku,
                COUNT(CASE WHEN doc_status.status = 'Diubah' THEN 1 END) AS total_dokumen_diubah,
                COUNT(CASE WHEN doc_status.status = 'Dicabut' THEN 1 END) AS total_dokumen_dicabut,
                COUNT(CASE WHEN doc_status.status = 'Tidak Berlaku' THEN 1 END) AS total_dokumen_tidak_berlaku
            FROM produk_hukum ph
            JOIN document_status doc_status ON doc_status.id = ph.status_id
            GROUP BY category_id";
        $statistics_breakdown = $this->db->table('document_categories doc_categ')
            ->select([
                "doc_categ.category AS kategori",
                "COALESCE(ph.total_dokumen, 0) AS total_dokumen",
                "COALESCE(ph.total_dokumen_berlaku, 0) AS total_dokumen_berlaku",
                "COALESCE(ph.total_dokumen_diubah, 0) AS total_dokumen_diubah",
                "COALESCE(ph.total_dokumen_dicabut, 0) AS total_dokumen_dicabut",
                "COALESCE(ph.total_dokumen_tidak_berlaku, 0) AS total_dokumen_tidak_berlaku",
            ])
            ->join(
                "($sq_ph) ph",
                'ph.category_id = doc_categ.id',
                'left',
                false
            )
            ->where("doc_categ.is_view", true)
            ->orderBy("doc_categ.id", 'asc')
            ->get()->getResultArray();
        $meta_page                      = [
            "title" => "Statistik",
            "total_document" => $total_document,
            "total_document_active" => $total_document_active,
            "total_document_ammended" => $total_document_ammended,
            "total_document_revoked" => $total_document_revoked,
            "statistics_breakdown" => $statistics_breakdown,
        ];
        return view('dashboard/user/statistics', $meta_page);
    }
    public function setting()
    {
        $userProfileModel = model(\App\Models\UserProfile::class);
        $user_id = $this->user->id;
        $user_profiles = $userProfileModel->getUserProfiles($user_id);
        return view('dashboard/user/settings', [
            "title" => 'Pengaturan',
            "profiles" => $user_profiles,
        ]);
    }
}
