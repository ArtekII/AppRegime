<?php

namespace App\Models;

use CodeIgniter\Model;

class ObjectifModel extends Model
{
    protected $table            = 'objectif';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'type',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    protected $useTimestamps = false;

    protected $validationRules = [
        'type' => 'required|in_list[Augmenter son poids,Réduire son poids,Atteindre son IMC idéal]',
    ];

    protected $validationMessages = [
        'type' => [
            'required' => 'Le champ "type" est obligatoire.',
            'in_list'  => 'Le type d\'objectif selectionne est invalide.',
        ],
    ];

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

    public function getSelectableObjectifs(): array
    {
        return $this->select('id, type')
            ->orderBy('id', 'ASC')
            ->findAll();
    }
}
