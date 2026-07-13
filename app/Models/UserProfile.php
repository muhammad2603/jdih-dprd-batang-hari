<?php

namespace App\Models;

use CodeIgniter\Model;

class UserProfile extends Model
{
    protected $table            = 'users_profile';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["id", "user_id", "nama_lengkap", "nama_divisi", "nomor_hp", "updated_at"];

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
     * Mengambil profil pengguna yang sedang login
     * @param int $user_id ID pengguna
     * @return array
     */
    public function getUserProfiles(int $user_id): array
    {
        return $this
            ->select([
                "nama_lengkap",
                "nama_divisi",
                "nomor_hp",
            ])
            ->where("user_id", $user_id)
            ->find()[0];
    }
}
