<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatPerubahanProdukHukum extends Model
{
    protected $table            = 'riwayat_perubahan_produk_hukum';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["id", "ph_id", "change_type", "status_changed", "comment", "changed_at"];

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

    public function getHistoriesChange(int $ph_id): array
    {
        return $this
            ->select([
                "change_type",
                "comment",
                "changed_at"
            ])
            ->where("ph_id", $ph_id)
            ->orderBy("changed_at", "DESC")
            ->findAll();
    }
}
