<?php

namespace App\Models;

use CodeIgniter\Model;

class ObjectifsRegimesActivite extends Model
{
    protected $table            = 'objectifsregimesactivites';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'objectif_id',
        'regime_id',
        'activite_id',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'date_creation';
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

    public function getRegimeAndActiviteByObjectifId($objectifId)
    {
        return $this->select('objectifsregimesactivites.*, regimes.nom as regime_nom, activites.nom as activite_nom')
            ->join('regimes', 'regimes.id = objectifsregimesactivites.regime_id')
            ->join('activites', 'activites.id = objectifsregimesactivites.activite_id')
            ->where('objectifsregimesactivites.objectif_id', $objectifId)
            ->findAll();
    }
}
