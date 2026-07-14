<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class ProdukHukum extends Model
{
    protected $table            = 'produk_hukum ph';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    // __FIX__ Jika ada perubahan (update data) dimeta data, update juga kolom updated_at ditable produk_hukum
    protected $allowedFields    = [
        "id",
        "title",
        "nomor",
        "tahun",
        "tanggal_penetapan",
        "tanggal_pengundangan",
        "tanggal_berlaku",
        "tajuk_entri_utama",
        "category_id",
        "status_id",
        "slug",
        "is_publish",
        "created_at",
        "updated_at",
        "deleted_at"
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Mengambil beberapa data produk hukum
     * @param int|null $perPage batas pengambilan data per-halaman (pagination)
     * @param int $offset indeks pengambilan data
     * @param bool|string $byKeyword keyword untuk mencari produk hukum berdasarkan field title, biarkan jika tidak ingin melakukan pencarian
     * @param bool|string $byCategory keyword untuk mencari produk hukum berdasarkan field category_id, biarkan jika tidak ingin melakukan pencarian
     * @param bool|string $byYear keyword untuk mencari produk hukum berdasarkan field tahun, biarkan jika tidak ingin melakukan pencarian
     * @return array
     */
    public function getProdukHukumHighlight(int|null $perPage = null, int $offset = 0, bool|string $byKeyword = false, bool|int $byCategory = false, bool|string $byYear = false, bool|string $byStatus = false): array
    {
        $selected_field = [
            "ph.id",
            "title AS judul",
            "nomor",
            "tahun",
            "status",
            "doccateg.category AS kategori",
            "doccateg.category_synonym AS kategori_sinonim",
            "tanggal_penetapan",
            "nama_berkas AS berkas",
            "slug",
            "DATE_FORMAT(ph.created_at, '%Y-%m-%d') AS tanggal_upload"
        ];
        $builder = $this
            ->select($selected_field)
            ->join("meta_produk_hukum mph", "mph.ph_id = ph.id")
            ->join("document_status docstat", "docstat.id = ph.status_id")
            ->join("document_categories doccateg", "doccateg.id = ph.category_id")
            ->join("lampiran_produk_hukum lph", "lph.ph_id = ph.id", 'left')
            ->where('ph.is_publish', true)
            ->groupBy("ph.id")
            ->orderBy("ph.created_at", "DESC")
            ->orderBy("ph.id", "DESC");
        if ($byKeyword !== false) {
            $builder->where("MATCH(title) AGAINST('$byKeyword' IN NATURAL LANGUAGE MODE)");
        }
        if ($byCategory !== false) {
            $builder->where("category_id", $byCategory);
        }
        if ($byYear !== false) {
            $builder->where("YEAR(tahun)", $byYear);
        }
        if ($byStatus !== false) {
            $builder->where("docstat.status", $byStatus);
        }
        return $builder->findAll($perPage, $offset);
    }

    /**
     * Mengambil total data produk hukum highlight
     * @param bool|string $byKeyword berdasarkan kata kunci pencarian
     * @param bool|int $byCategory berdasarkan kategori
     * @param bool|string $byYear berdasarkan tahun upload
     * @return int
     */
    public function getTotalProdukHukumHighlight(bool|string $byKeyword = false, bool|int $byCategory = false, bool|string $byYear = false, bool|string $byStatus = false): int
    {
        $builder = $this
            ->select("ph.id")
            ->join("meta_produk_hukum mph", "mph.ph_id = ph.id")
            ->join("document_status docstat", "docstat.id = ph.status_id")
            ->join("document_categories doccateg", "doccateg.id = ph.category_id")
            ->join("lampiran_produk_hukum lph", "lph.ph_id = ph.id", 'left')
            ->where('ph.is_publish', true)
            ->groupBy("ph.id");
        if ($byKeyword !== false) {
            $builder->where("MATCH(title) AGAINST('$byKeyword' IN NATURAL LANGUAGE MODE)");
        };
        if ($byCategory !== false) {
            $builder->where("category_id", $byCategory);
        };
        if ($byYear !== false) {
            $builder->where("YEAR(tahun)", $byYear);
        };
        if ($byStatus !== false) {
            $builder->where("docstat.status", $byStatus);
        };
        return $builder->countAllResults();
    }

    /**
     * Mengambil detail produk hukum
     * @param int|string $key field id atau slug produk hukum
     * @param string|null $category kategori produk hukum yang ingin dicari. Default null
     * @return array|bool false jika produk hukum memiliki status publish = false
     */
    public function getProdukHukumDetails(int|string $key, string|null $category = null): array|bool
    {
        $builder = $this
            ->select([
                "ph.id",
                "ph.title AS judul",
                "category AS kategori",
                "category_synonym AS singkatan_kategori",
                "abstrak",
                "catatan",
                "nomor",
                "tahun",
                "nomor_tld",
                "tahun_tld",
                "pjb.nama AS tajuk_entri_utama",
                "(
                    CASE
                        WHEN docstat.sinonim IS NULL THEN docstat.status
                        ELSE docstat.sinonim
                    END
                ) AS status",
                "warna_aksen",
                "sumber",
                "(
                SELECT nama FROM pejabat pjb WHERE pjb.id = mph.pembuat_peraturan
                ) AS pejabat_pembuat_peraturan",
                "(
                    SELECT nama FROM pejabat pjb WHERE pjb.id = mph.penandatanganan
                ) AS pejabat_penandatanganan",
                "(
                    SELECT nama FROM pejabat pjb WHERE pjb.id = mph.pejabat_penetap
                ) AS pejabat_penetap",
                "tanggal_penetapan",
                "tanggal_pengundangan",
                "tanggal_berlaku",
                "lokasi AS tempat_penetapan",
                "(
                    SELECT lokasi FROM lokasi_produk_hukum sub_lph WHERE sub_lph.id = mph.lokasi_terbit
                ) AS lokasi_terbit",
                "GROUP_CONCAT(
                    CONCAT(lph.judul_berkas, ':', lph.nama_berkas)
                    ORDER BY lph.id DESC
                    SEPARATOR ','
                ) AS berkas",
                "mph.abstrak_pdf",
                "ph.slug",
                "ph.created_at",
                "ph.updated_at"
            ])
            ->join("document_categories doccateg", "doccateg.id = ph.category_id")
            ->join("meta_produk_hukum mph", "mph.ph_id = ph.id")
            ->join("pejabat pjb", "pjb.id = ph.tajuk_entri_utama")
            ->join("document_status docstat", "docstat.id = ph.status_id")
            ->join("sumber_produk_hukum sph", "sph.id = mph.sumber_id")
            ->join("lokasi_produk_hukum lokph", "lokph.id = mph.tempat_penetapan")
            ->join("lampiran_produk_hukum lph", "lph.ph_id = ph.id", 'left')
            ->where('ph.is_publish', true);
        if (!is_null($category)) {
            $builder->where("doccateg.category", $category);
        }
        if (is_int($key)) {
            $builder->where("ph.id", $key);
        } else if (is_string($key)) {
            $builder->where("slug", $key);
        }
        $result = $builder->first();
        return !is_null($result["id"]) ? $result : false;
    }

    /**
     * Mengambil klasifikasi produk hukum
     * @param int $id ID produk hukum
     * @return array ["bidang_hukum", "subjek"]
     */
    public function getClassifyProdukHukum(int $id): array
    {
        $klasifikasi_bidang_hukum = $this
            ->select("GROUP_CONCAT(
                    kat_bh.kategori
                    SEPARATOR ', '
                ) AS bidang_hukum")
            ->join("klasifikasi_bidang_hukum kbh", "kbh.ph_id = ph.id")
            ->join("kategori_bidang_hukum kat_bh", "kat_bh.id = kbh.bidang_hukum_id")
            ->where("ph.id", $id)
            ->first()["bidang_hukum"];
        $klasifikasi_subjek = $this
            ->select("GROUP_CONCAT(
                    kat_sub.subjek
                    SEPARATOR ', '
                ) AS subjek")
            ->join("klasifikasi_subjek ks", "ks.ph_id = ph.id")
            ->join("kategori_subjek kat_sub", "kat_sub.id = ks.subjek_id")
            ->where("ph.id", $id)
            ->first()["subjek"];
        return [
            "bidang_hukum" => $klasifikasi_bidang_hukum,
            "subjek" => $klasifikasi_subjek,
        ];
    }

    /**
     * Mengambil dokumen terkait
     * @param int $ph_id ID Produk Hukum
     * @return array
     */
    public function getRelatedDocuments(int $ph_id): array
    {
        return $this
            ->select([
                "rd.id",
                "rd.judul",
                "rd.nomor",
                "rd.tahun",
                "doc_categ.id AS category_id",
                "doc_categ.category AS full_name_category",
                "(
                    CASE
                        WHEN doc_categ.category_synonym IS NULL THEN UPPER(doc_categ.category)
                        ELSE UPPER(doc_categ.category_synonym)
                    END
                ) AS kategori",
                "docstatact.action AS ref_status"
            ])
            ->join("related_document rd", "rd.ph_id = ph.id")
            ->join("document_categories doc_categ", "doc_categ.id = rd.category_id")
            ->join("document_status_action docstatact", "docstatact.id = rd.status_action")
            ->where("rd.ph_id", $ph_id)
            ->findAll();
    }

    /**
     * Mengambil total produk hukum yang tersedia
     * @return array ["total" => int]
     */
    public function getTotalDocument(): array
    {
        return $this
            ->select("COUNT(*) AS total")
            ->findAll()[0];
    }

    /**
     * Mengambil total dokumen berdasarkan bulan
     * @param string $target_month bulan pembuatan dokumen yang dicari
     * @return int
     */
    public function getTotalDocumentByMonth(string $target_month): int
    {
        return $this
            ->select()
            ->where("MONTH(created_at) =", $target_month)
            ->countAllResults();
    }

    /**
     * Mengambil total dokumen berdasarkan tahun
     * @param string $target_year tahun pembuatan dokumen yang dicari
     * @return int
     */
    public function getTotalDocumentByYear(string $target_year): int
    {
        return $this
            ->select()
            ->where("YEAR(created_at) =", $target_year)
            ->countAllResults();
    }

    /**
     * Mengambil total dokumen per-tahun
     * @return array
     */
    public function getTotalDocumentPerYears(): array
    {
        $subquery = $this->db->table("produk_hukum")
            ->select([
                "YEAR(created_at) AS tahun",
                "COUNT(*) AS total"
            ])
            ->groupBy("YEAR(created_at)");
        return $this->db->newQuery()
            ->select("GROUP_CONCAT(tahun, ':', total) AS result")
            ->fromSubquery($subquery, "sq")
            ->get()->getFirstRow('array');
    }

    /**
     * Mengambil total dokumen hukum berdasarkan kategori-nya
     * @return array
     */
    public function getTotalDocumentByCategory(): array
    {
        return $this->db->table("document_categories doc_categ")
            ->select([
                "doc_categ.id AS category_id",
                "doc_categ.category AS kategori",
                "icons.icon_name AS icon",
                "icons.color",
                "COUNT(ph.id) AS total_dokumen"
            ])
            ->join(
                "produk_hukum ph",
                "ph.category_id = doc_categ.id",
                "left"
            )
            ->join("icons", 'icons.id = doc_categ.icon')
            ->where("doc_categ.is_view", true)
            ->groupBy("doc_categ.id")
            ->orderBy("total_dokumen", "DESC")
            ->get()
            ->getResultArray();
    }

    /**
     * Mengambil total dokumen berdasarkan kategori
     * @param int $limit batas hasil pengambilan baris data
     * @return array
     */
    public function getTotalDocByCategories(int $limit = 5): array
    {
        $subquery = $this->db->table("produk_hukum")
            ->select([
                "doc_categ.category AS kategori",
                "COUNT(category_id) AS total"
            ])
            ->join("document_categories doc_categ", "doc_categ.id = produk_hukum.category_id")
            ->groupBy("category_id");
        return $this->db->newQuery()
            ->select("GROUP_CONCAT(kategori, ':', total) AS result")
            ->fromSubquery($subquery, 'sq')
            ->limit($limit)
            ->get()->getFirstRow('array');
    }

    /**
     * Mengambil total dokumen per-bulan ditahun saat ini
     * @return array
     */
    public function getTotalDocPerMonths(): array
    {
        $subquery = $this->db->table('produk_hukum')
            ->select([
                "MONTHNAME(created_at) AS bulan",
                "COUNT(*) AS total"
            ])
            ->where("YEAR(created_at)", Time::now()->getYear())
            ->groupBy("MONTH(created_at)");
        return $this->db->newQuery()
            ->select("GROUP_CONCAT(CONCAT(bulan, ':', total) ORDER BY bulan SEPARATOR ',') AS result")
            ->fromSubquery($subquery, "sq")
            ->get()->getFirstRow('array');
    }

    /**
     * Mengambil tahun upload dokumen, digunakan untuk opsi pilihan
     * @param bool|int $by_category mengambil tahun upload dokumen berdasarkan kategori
     * @return array
     */
    public function getYearsDocumentUploaded(bool|int $by_category = false): array
    {
        $builder = $this
            ->select("DISTINCT YEAR(created_at) AS tahun");
        if ($by_category !== false) {
            $builder->where("category_id", $by_category);
        }
        return $builder->findAll();
    }

    /**
     * Mengambil produk hukum beserta metadata untuk feed
     * @param array $fields field yang ingin diambil
     * @param string $order_by urutan data berdasarkan timestamp created_at dan id, default desc dengan urutan dari terbaru-terlama
     * @return array
     */
    public function getProdukHukumFeed(array $fields, string $order_by = 'desc'): array
    {
        return $this
            ->select($fields)
            ->join("meta_produk_hukum mph", 'mph.ph_id = ph.id', 'inner')
            ->join("document_categories doc_categs", 'doc_categs.id = ph.category_id', 'inner')
            ->join("document_status doc_status", 'doc_status.id = ph.status_id')
            ->join("sumber_produk_hukum sph", 'sph.id = mph.sumber_id')
            ->join("klasifikasi_bidang_hukum klf_bh", 'klf_bh.ph_id = ph.id')
            ->join("kategori_bidang_hukum kbh", 'kbh.id = klf_bh.bidang_hukum_id')
            ->where("ph.is_publish", true)
            ->orderBy('ph.created_at', $order_by)
            ->orderBy('ph.id', $order_by)
            ->groupBy('ph.id')
            ->findAll();
    }

    /**
     * Mengambil tahun peraturan produk hukum yang tersedia didatabase
     * @param string $order_by (asc|desc) Mengatur urutan tahun, default asc (terendah - tertinggi)
     * @return array
     */
    public function getYearsProductLaw(string $order_by = 'asc'): array
    {
        return $this
            ->select("tahun")
            ->distinct()
            ->orderBy("tahun", $order_by)
            ->findAll();
    }

    /**
     * Menghitung total dokumen hukum berdasarkan status
     * @param string $status status dokumen yang ingin dicari
     * @return int
     */
    public function getTotalDocumentByStatus(string $status): int
    {
        return $this
            ->select()
            ->join("document_status docstat", "docstat.id = ph.status_id")
            ->where("docstat.status", $status)
            ->countAllResults();
    }
}
