<?php

namespace App\Models;

use CodeIgniter\Model;

class PagesMeta extends Model
{
    protected $table            = 'pages_meta';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["id", "page_identity", "meta"];

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
     * Mengambil meta halaman berdasarkan identitas halaman
     * 
     * @param string $pageIdentity Identitas halaman
     * @param bool $resultToArray Mengembalikan hasil menjadi Array, jika false, akan mengembalikan hasil JSON String
     * 
     * @return array
     * 
     */
    public function getMetaPagesByIdentity(string $pageIdentity, bool $resultToArray = true): array|string
    {
        $data = $this
            ->select("meta")
            ->where("page_identity", $pageIdentity)
            ->first();

        if ($resultToArray) {
            return json_decode($data["meta"], true);
        } else {
            return $data["meta"];
        }
    }
}
