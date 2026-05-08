<?php

namespace App\Models;

use CodeIgniter\Model;

class UtilisateurObjectifModel extends Model
{
    protected $table            = 'utilisateur_objectif';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'utilisateur_id',
        'objectif_id',
        'statut_id',
        'imc_cible',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    protected $useTimestamps = false;

    protected $validationRules = [
        'utilisateur_id' => 'required|is_natural_no_zero',
        'objectif_id'    => 'required|is_natural_no_zero',
        'statut_id'      => 'required|is_natural_no_zero',
        'imc_cible'      => 'permit_empty|decimal|greater_than_equal_to[18.5]|less_than_equal_to[24.9]',
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

    public function setObjectifForUser(int $utilisateurId, int $objectifId, ?float $imcCible = null): bool
    {
        $existing = $this->where('utilisateur_id', $utilisateurId)->first();
        $statutModel = new StatutModel();
        $statutId = $statutModel->getDefaultId();

        if ($existing === null) {
            return $this->insert([
                'utilisateur_id' => $utilisateurId,
                'objectif_id' => $objectifId,
                'statut_id' => $statutId,
                'imc_cible' => $imcCible,
            ]) !== false;
        }

        return $this->update((int) $existing['id'], [
            'objectif_id' => $objectifId,
            'statut_id' => $statutId,
            'imc_cible' => $imcCible,
        ]);
    }
}
