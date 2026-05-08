<?php

namespace App\Models;

use CodeIgniter\Model;

class ActiviteObjectifModel extends Model
{
    protected $table            = 'activite_objectif';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'activite_id',
        'objectif_id',
        'duree_jours',
        'frequence_par_semaine',
        'duree_minutes_par_seance',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    protected $useTimestamps = false;

    protected $validationRules = [
        'activite_id'                => 'required|is_natural_no_zero',
        'objectif_id'                => 'required|is_natural_no_zero',
        'duree_jours'                => 'required|is_natural_no_zero',
        'frequence_par_semaine'      => 'required|is_natural_no_zero',
        'duree_minutes_par_seance'   => 'required|is_natural_no_zero',
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

    public function getActivitesByObjectifId(int $objectifId): array
    {
        return $this->select('activite_objectif.*, activite_sportive.nom as activite_nom')
            ->join('activite_sportive', 'activite_sportive.id = activite_objectif.activite_id')
            ->where('activite_objectif.objectif_id', $objectifId)
            ->findAll();
    }
}
