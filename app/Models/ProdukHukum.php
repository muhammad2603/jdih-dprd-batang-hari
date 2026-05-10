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
        "category_id",
        "status_id",
        "slug",
        "created_at",
        "updated_at",
        "deleted_at"
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
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

    // __FIX__ jika bisa, satukan dengan query yang menampilkan data lengkapnya
    // ^^^^^^^^^^ jika bisa, ambil field yang wajib dan pisahkan field yang opsional dan bisa dipilih secara manual, agar field lebih spesifik (yang diinginkan) saat dibutuhkan
    /**
     * Mengambil beberapa data produk hukum
     * @param int|null $perPage batas pengambilan data per-halaman (pagination)
     * @param int $offset indeks pengambilan data
     * @param bool|string $byKeyword keyword untuk mencari produk hukum berdasarkan field title, biarkan jika tidak ingin melakukan pencarian
     * @param bool|string $byCategory keyword untuk mencari produk hukum berdasarkan field category_id, biarkan jika tidak ingin melakukan pencarian
     * @param bool|string $byYear keyword untuk mencari produk hukum berdasarkan field tahun, biarkan jika tidak ingin melakukan pencarian
     * @return array
     */
    public function getProdukHukumHighlight(int|null $perPage = null, int $offset = 0, bool|string $byKeyword = false, bool|int $byCategory = false, bool|string $byYear = false): array
    {
        $selected_field = [
            "title AS judul",
            "nomor",
            "tahun",
            "status",
            "doccateg.category AS kategori",
            "tanggal_penetapan",
            "nama_berkas AS berkas",
            "ru.counts AS total_unduhan",
            "slug",
            "DATE_FORMAT(ph.created_at, '%Y-%m-%d') AS tanggal_upload"
        ];
        $builder = $this
            ->select($selected_field)
            ->join("meta_produk_hukum mph", "mph.ph_id = ph.id")
            ->join("document_status docstat", "docstat.id = ph.status_id")
            ->join("document_categories doccateg", "doccateg.id = ph.category_id")
            ->join("lampiran_produk_hukum lph", "lph.ph_id = ph.id")
            ->join("riwayat_unduhan ru", "ru.ph_id = ph.id")
            ->groupBy("ph.id")
            ->orderBy("ph.created_at", "DESC")
            ->orderBy("ph.id", "DESC");
        if ($byKeyword !== false) {
            $builder->where("MATCH(title) AGAINST('$byKeyword' IN NATURAL LANGUAGE MODE)");
        };
        if ($byCategory !== false) {
            $builder->where("category_id", $byCategory);
        };
        if ($byYear !== false) {
            $builder->where("YEAR(tahun)", $byYear);
        };
        return $builder->findAll($perPage, $offset);
    }
    /**
     * Mengambil total data produk hukum highlight
     * @param bool|string $byKeyword berdasarkan kata kunci pencarian
     * @param bool|int $byCategory berdasarkan kategori
     * @param bool|string $byYear berdasarkan kata kunci tahun
     * @return int
     */
    public function getTotalProdukHukumHighlight(bool|string $byKeyword = false, bool|int $byCategory = false, bool|string $byYear = false): int
    {
        $builder = $this
            ->select("ph.id")
            ->join("meta_produk_hukum mph", "mph.ph_id = ph.id")
            ->join("document_status docstat", "docstat.id = ph.status_id")
            ->join("document_categories doccateg", "doccateg.id = ph.category_id")
            ->join("lampiran_produk_hukum lph", "lph.ph_id = ph.id")
            ->join("riwayat_unduhan ru", "ru.ph_id = ph.id")
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
        return $builder->countAllResults();
    }
    /**
     * Mengambil detail produk hukum
     * @param int|string $key field id atau slug produk hukum
     * @param string|null $category kategori produk hukum yang ingin dicari. Default null
     * @return array
     */
    public function getProdukHukumDetails(int|string $key, string|null $category = null): array
    {
        $builder = $this
            ->select([
                "ph.id",
                "ph.title AS judul",
                "abstrak",
                "catatan",
                "nomor",
                "tahun",
                "nomor_tld",
                "tahun_tld",
                "status",
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
                "counts AS total_unduhan",
                "jumlah_halaman",
                "ph.created_at",
                "ph.updated_at"
            ])
            ->join("meta_produk_hukum mph", "mph.ph_id = ph.id")
            ->join("document_status docstat", "docstat.id = ph.status_id")
            ->join("sumber_produk_hukum sph", "sph.id = mph.sumber_id")
            ->join("lokasi_produk_hukum lokph", "lokph.id = mph.tempat_penetapan")
            ->join("lampiran_produk_hukum lph", "lph.ph_id = ph.id")
            ->join("riwayat_unduhan ru", "ru.ph_id = ph.id");
        if (!is_null($category)) {
            $builder
                ->select([
                    "category AS kategori",
                    "category_synonym AS singkatan_kategori"
                ])
                ->join("document_categories doccateg", "doccateg.id = ph.category_id")
                ->where("doccateg.category", $category);
        }
        if (is_int($key)) {
            $builder->where("id", $key);
        } else if (is_string($key)) {
            $builder->where("slug", $key);
        }
        return $builder->first();
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
                "ph.title AS judul",
                "ph.nomor",
                "ph.tahun",
                "(
                    CASE
                        WHEN doc_categ.category_synonym IS NULL THEN doc_categ.category
                        ELSE doc_categ.category_synonym
                    END
                ) AS kategori",
                "status AS ref_status"
            ])
            ->join("document_categories doc_categ", "doc_categ.id = ph.category_id")
            ->join("related_document rd", "rd.related_ph_id = ph.id")
            ->join("document_status docstat", "docstat.id = rd.related_status")
            ->where("rd.ph_id", $ph_id)
            ->findAll();
    }
    /**
     * Mengambil total dokumen hukum berdasarkan kategori-nya
     * @return array
     */
    public function getTotalDocumentByCategory(): array
    {
        return $this
            ->select([
                "doc_categ.category AS kategori",
                "COUNT(*) AS total_dokumen"
            ])
            ->join("document_categories doc_categ", "doc_categ.id = ph.category_id")
            ->groupBy("ph.category_id")
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
}
