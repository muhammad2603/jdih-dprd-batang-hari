<?php

namespace App\Models;

use CodeIgniter\Model;

class MetaProdukHukum extends Model
{
    protected $table            = 'meta_produk_hukum';
    protected $primaryKey       = 'ph_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["ph_id", "abstrak", "abstrak_pdf", "catatan", "sumber_id", "tempat_penetapan", "nomor_tld", "tahun_tld", "pembuat_peraturan", "penandatanganan", "pejabat_penetap", "lokasi_terbit", "bahasa", "jumlah_halaman"];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    // protected $useTimestamps = false;
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
}
