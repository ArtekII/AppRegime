<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimeObjectifModel extends Model
{
    protected $table            = 'regime_objectif';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'regime_id',
        'objectif_id',
        'poids_min',
        'poids_max',
        'duree_jours',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    protected $useTimestamps = false;

    protected $validationRules = [
        'regime_id'   => 'required|is_natural_no_zero',
        'objectif_id' => 'required|is_natural_no_zero',
        'poids_min'   => 'required|numeric',
        'poids_max'   => 'required|numeric',
        'duree_jours' => 'required|is_natural_no_zero',
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

    public function getRegimesByObjectifId(int $objectifId): array
    {
        return $this->select(
            'regime_objectif.*, regime.nom as regime_nom, regime.pourcentage_viandes, '
            . 'regime.pourcentage_poissons, regime.pourcentage_volailles, '
            . 'prix_regimes.id as prix_regime_id, prix_regimes.prix as prix'
        )
            ->join('regime', 'regime.id = regime_objectif.regime_id')
            ->join(
                'prix_regimes',
                'prix_regimes.regime_id = regime_objectif.regime_id '
                . 'AND prix_regimes.duree_jours = regime_objectif.duree_jours',
                'left'
            )
            ->where('regime_objectif.objectif_id', $objectifId)
            ->findAll();
    }

    public function getRegimeAndActiviteByObjectifId(int $objectifId): array
    {
        return $this->select(
            'regime_objectif.*, regime.nom as regime_nom, activite_sportive.nom as activite_nom, '
            . 'activite_objectif.frequence_par_semaine, activite_objectif.duree_minutes_par_seance'
        )
            ->join('regime', 'regime.id = regime_objectif.regime_id')
            ->join('activite_objectif', 'activite_objectif.objectif_id = regime_objectif.objectif_id', 'left')
            ->join('activite_sportive', 'activite_sportive.id = activite_objectif.activite_id', 'left')
            ->where('regime_objectif.objectif_id', $objectifId)
            ->findAll();
    }
}
