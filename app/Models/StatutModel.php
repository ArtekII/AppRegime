<?php

namespace App\Models;

use CodeIgniter\Model;

class StatutModel extends Model
{
    protected $table            = 'statut';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nom',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    protected $useTimestamps = false;

    protected $validationRules = [
        'nom' => 'required|max_length[255]',
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

    public function getDefaultId(): int
    {
        $statut = $this->select('id')
            ->where('nom', 'En cours')
            ->first();

        if ($statut !== null) {
            return (int) $statut['id'];
        }

        return (int) $this->insert(['nom' => 'En cours'], true);
    }
}
