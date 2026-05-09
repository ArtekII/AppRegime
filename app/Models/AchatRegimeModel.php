<?php

namespace App\Models;

use CodeIgniter\Model;

class AchatRegimeModel extends Model
{
    protected $table            = 'achat_regime';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'utilisateur_id',
        'prix_regime_id',
        'montant',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = false;

    protected $validationRules = [
        'utilisateur_id'  => 'required|is_natural_no_zero',
        'prix_regime_id'  => 'required|is_natural_no_zero',
        'montant'         => 'required|numeric|greater_than[0]',
    ];
}
