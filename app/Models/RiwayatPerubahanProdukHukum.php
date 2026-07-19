<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatPerubahanProdukHukum extends Model
{
    protected $table            = 'riwayat_perubahan_produk_hukum rpph';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["id", "ph_id", "rdp_id", "change_type"];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    // protected $dateFormat    = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

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
     * Ambil riwayat perubahan produk hukum
     * @param int $ph_id ID Produk Hukum
     * @param string $orderByChanged Urutan yang akan ditentukan, default desc. [DESC|ASC]
     * @return array
     */
    public function getHistoriesChange(int $ph_id, string $orderByChanged = "DESC"): array
    {
        $selected_fields = [
            "rdp.id",
            "trp.tipe AS change_type",
            "doc_categ.category_synonym AS kategori",
            "rdp.nomor",
            "rdp.tahun",
            "rdp.comment",
            "changed_at"
        ];
        return $this
            ->select($selected_fields)
            ->join("produk_hukum ph", "ph.id = $ph_id")
            ->join("riwayat_detail_perubahan rdp", "rdp.id = rpph.rdp_id")
            ->join("tipe_riwayat_perubahan trp", 'trp.id = rpph.change_type')
            ->join("document_categories doc_categ", "doc_categ.id = rdp.category_id", "LEFT")
            ->where("rpph.ph_id", $ph_id)
            ->orderBy("rdp.changed_at", $orderByChanged)
            ->findAll();
    }
}
