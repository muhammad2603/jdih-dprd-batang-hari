<?php

namespace App\Models;

use CodeIgniter\Model;

class FrontendConfig extends Model
{
    protected $table            = 'frontend_config feconf';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["id", "content", "link", "page_id", "component_id", "category_id"];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

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
     * Mengambil path Logo
     * 
     * @return array
     */
    public function getLogo(): array
    {
        return $this
            ->select("content, link")
            ->join("frontend_categories fecateg", "fecateg.id = feconf.category_id")
            ->where("fecateg.category", "Logo")
            ->first();
    }
    /**
     * Mengambil data navigasi beserta link untuk header
     * 
     * @return array
     */
    public function getNavigationHeader(): array
    {
        return $this
            ->select("content, link")
            ->join("frontend_components fecomp", "fecomp.id = feconf.component_id")
            ->join("frontend_categories fecateg", "fecateg.id = feconf.category_id")
            ->where("fecomp.component", "Header")
            ->where("fecateg.category", "Navigasi")
            ->findAll();
    }
    /**
     * Mengambil identitas
     * 
     * @return array
     */
    public function getIdentity(): array
    {
        return $this
            ->select("content")
            ->join("frontend_categories fecateg", "fecateg.id = feconf.category_id")
            ->where("fecateg.category", "Identitas")
            ->orderBy("feconf.id", "ASC")
            ->findAll();
    }

    public function getAllData(): array
    {
        return $this
            ->select("content, link, component, category")
            ->join("frontend_components fecomp", "fecomp.id = feconf.component_id")
            ->join("frontend_categories fecateg", "fecateg.id = feconf.category_id")
            ->findAll();
    }
}
