<?php

namespace App\Models;

use CodeIgniter\Model;

class AbonnementGoldModel extends Model
{
    protected $table            = 'abonnements_gold';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['utilisateur_id', 'prix', 'date_activation'];
}
