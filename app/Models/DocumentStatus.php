<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentStatus extends Model
{
    protected $table            = 'document_status';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["id", "sinonim"];

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

    // Mengambil status untuk opsi pemilihan berdasarkan status
    protected $selectStatus = [
        "Penetapan",
        "Pencabutan",
        "Berlaku",
        "Tidak Berlaku",
    ];

    /**
     * Mengambil status yang tersedia di Database
     * @param bool $selectAll Mengambil semua status yang tersedia, jika false, hanya akan mengambil status yang ada diproperty selectStatus
     * @return array
     */
    public function getStatus($selectAll = false): array
    {
        $builder = $this->select("status");
        if ($selectAll === false) {
            $builder->whereIn("status", $this->selectStatus);
        }
        return $builder->findAll();
    }
}
