<?php

namespace App\Models;

use CodeIgniter\Model;

class PrixRegimeModel extends Model
{
    protected $table            = 'prix_regimes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'duree_jours',
        'regime_id',
        'prix',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    protected $useTimestamps = false;

    protected $validationRules = [
        'duree_jours' => 'required|is_natural_no_zero',
        'regime_id'   => 'required|is_natural_no_zero',
        'prix'        => 'required|numeric|greater_than[0]',
    ];

    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getPrixByRegimeId(int $regimeId): array
    {
        return $this->where('regime_id', $regimeId)
            ->orderBy('duree_jours', 'ASC')
            ->findAll();
    }
}
