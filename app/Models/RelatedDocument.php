<?php

namespace App\Models;

use CodeIgniter\Model;

class RelatedDocument extends Model
{
    protected $table            = 'related_document rd';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

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
     * Menghitung total relasi dokumen hukum berdasarkan aksi
     * @param string $action aksi yang ingin dicari
     * @return int
     */
    public function getTotalRelatedDocumentByAction(string $action): int
    {
        return $this
            ->select("rd.ph_id")
            ->join("document_status_action docstat_action", "docstat_action.id = rd.status_action")
            ->where("docstat_action.action", $action)
            ->groupBy("rd.ph_id")
            ->countAllResults();
    }
}
