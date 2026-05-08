<?php

namespace App\Models;

use CodeIgniter\Model;

class UtilisateursObjectifsModel extends Model
{
    protected $table            = 'utilisateurs_objectifs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'utilisateur_id',
        'objectif_id',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    protected $useTimestamps = false;

    protected $validationRules      = [];
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

    public function setObjectifForUser(int $utilisateurId, int $objectifId): bool
    {
        $existing = $this->where('utilisateur_id', $utilisateurId)->first();

        if ($existing === null) {
            return $this->insert([
                'utilisateur_id' => $utilisateurId,
                'objectif_id' => $objectifId,
            ]) !== false;
        }

        return $this->update((int) $existing['id'], [
            'objectif_id' => $objectifId,
        ]);
    }
}
