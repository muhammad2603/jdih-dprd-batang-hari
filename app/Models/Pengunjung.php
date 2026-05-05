<?php

namespace App\Models;

use CodeIgniter\Model;

class Pengunjung extends Model
{
    protected $table            = 'pengunjung';
    protected $primaryKey       = 'ip_address';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["ip_address", "count"];

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

    public function updateCount(string $ip_address)
    {
        $db = $this->db;
        $db->transBegin();
        $is_ip_exist = $this->where("ip_address", $ip_address)->first();
        if (is_null($is_ip_exist)) {
            $this->insert(["ip_address" => $ip_address]);
        }
        $this
            ->where("ip_address", $ip_address)
            ->set("count", "count+1", false)
            ->update();
        if ($db->transStatus() === false) {
            $db->transRollback();
            return false;
        }
        $db->transCommit();
        return true;
    }
}
