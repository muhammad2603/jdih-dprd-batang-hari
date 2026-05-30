<?php

namespace App\Models;

use CodeIgniter\Model;

class TopikBantuan extends Model
{
    protected $table            = 'topik_bantuan tb';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["id", "topik", "deskripsi", "attachment", "link", "icon", "created_at", "updated_at", "deleted_at"];

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
     * Mengambil topik bantuan
     * @param string $order_by urutan berdasarkan tanggal upload
     * @return array
     */
    public function getTopicsHelp(string $order_by = 'desc'): array
    {
        return $this
            ->select([
                "topik",
                "deskripsi",
                "attachment",
                "link",
                "icons.icon_name AS icon"
            ])
            ->join("icons", 'icons.id = tb.icon', 'left')
            ->orderBy("created_at", $order_by)
            ->findAll();
    }
}
