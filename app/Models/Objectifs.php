<?php

namespace App\Models;

use CodeIgniter\Model;

class Objectifs extends Model
{
    protected $table            = 'objectifs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'type',
        'date_creation',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'date_creation';
    protected $updatedField  = 'date_modification';
    protected $deletedField  = 'date_suppression';

    // Validation
    protected $validationRules      = [
        'type' => 'required|string|max_length[255]',
    ];
    protected $validationMessages   = [
        'type' => [
            'required' => 'Le champ "type" est obligatoire.',
            'string'   => 'Le champ "type" doit être une chaîne de caractères.',
            'max_length' => 'Le champ "type" ne peut pas dépasser 255 caractères.',
        ],
    ];
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
}
