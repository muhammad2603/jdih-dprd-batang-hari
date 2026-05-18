<?php

namespace App\Models;

use CodeIgniter\Model;

class FaqModel extends Model
{
    protected $table            = 'faq';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["id", "judul", "deskripsi", "faq_kategoi_id"];

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
     * Mengambil data FAQ dari Database
     * @param array $order_by["field" => ..., "sort" => ASC|DESC] mengatur urutan data
     * @param bool|string $by_keyword mencari faq berdasarkan kata kunci pencarian
     * @param bool|string $by_category mencari faq berdasarkan kategori
     * @return array
     */
    public function getFaq(array $order_by, bool|string $by_keyword = false, bool|string $by_category = false): array
    {
        $builder = $this
            ->select([
                "judul",
                "deskripsi",
                "kategori"
            ])
            ->join("kategori_faq kf", 'kf.id = faq.faq_kategori_id', 'inner');
        if ($by_category !== false) {
            $builder
                ->where("kf.kategori", $by_category)
                ->orderBy("faq.id", 'DESC');
        } else {
            $builder->orderBy($order_by["field"], $order_by["sort"]);
        }
        if ($by_keyword !== false) {
            $builder->like('faq.judul', $by_keyword, 'left');
        }
        return $builder->findAll();
    }
}
