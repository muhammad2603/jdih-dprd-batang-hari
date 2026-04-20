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
}
