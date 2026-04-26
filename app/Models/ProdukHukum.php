<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukHukum extends Model
{
    protected $table            = 'produk_hukum ph';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
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

    /**
     * Mengambil beberapa data produk hukum
     * 
     * @param int|null $limit [opsional] total data yang ingin diambil
     * 
     * @return array ["judul", "nomor", "tahun", "status", "kategori", "tanggal_penetapan" "total_unduhan", "berkas", "slug", "total_data", "tanggal_upload"]
     * 
     * // __FIX__ jika bisa, satukan dengan query yang menampilkan data lengkapnya
     * ^^^^^^^^^^ jika bisa, ambil field yang wajib dan pisahkan field yang opsional dan bisa dipilih secara manual, agar field lebih spesifik (yang diinginkan) saat dibutuhkan
     */
    public function getProdukHukumHighlight(int|null $limit = null): array
    {
        $data = $this
            ->select([
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
            ])
            ->join("meta_produk_hukum mph", "mph.ph_id = ph.id")
            ->join("document_status docstat", "docstat.id = ph.status_id")
            ->join("document_categories doccateg", "doccateg.id = ph.category_id")
            ->join("lampiran_produk_hukum lph", "lph.ph_id = ph.id")
            ->join("riwayat_unduhan ru", "ru.ph_id = ph.id")
            ->groupBy("ph.id")
            ->orderBy("ph.created_at", "DESC")
            ->orderBy("ph.id", "DESC");
        return [
            "results"       => $data->findAll($limit),
            "total_data"    => $data->countAllResults(),
        ];
    }

    public function getProdukHukumDetails(int|string $key, string|null $category = null): array|null
    {
        $builder = $this->select([
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
            "jumlah_halaman"
        ])
            ->join("meta_produk_hukum mph", "mph.ph_id = ph.id")
            ->join("document_status docstat", "docstat.id = ph.status_id")
            ->join("sumber_produk_hukum sph", "sph.id = mph.sumber_id")
            ->join("lokasi_produk_hukum lokph", "lokph.id = mph.tempat_penetapan")
            ->join("lampiran_produk_hukum lph", "lph.ph_id = ph.id")
            ->join("riwayat_perubahan_produk_hukum rppu", "rppu.ph_id = ph.id", "LEFT")
            ->join("riwayat_unduhan ru", "ru.ph_id = ph.id");

        if (!is_null($category)) {
            $builder
                ->select("category AS kategori")
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
}
