<?php

namespace App\Models;

use CodeIgniter\Model;

class Code extends Model
{
    protected $table = 'code_montant';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['code', 'montant', 'utilise'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        "code" => "required|min_length[3]|max_length[50]",
        "montant" => "required|numeric|greater_than[0]"
    ];
    protected $validationMessages = [
        "code" => [
            "required" => "Le champ code est obligatoire.",
            "min_length" => "Le code doit contenir au moins 3 caractères.",
            "max_length" => "Le code ne doit pas dépasser 50 caractères."
        ],
        "montant" => [
            "required" => "Le montant est obligatoire.",
            "numeric" => "Le montant doit être un nombre.",
            "greater_than" => "Le montant doit être supérieur à 0."
        ]
    ];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];
}
