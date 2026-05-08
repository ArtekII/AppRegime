<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimeModel extends Model
{
    protected $table            = 'regimes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['nom', 'variation_poids', 'duree', 'prix', 'pourcentage_viandes', 'pourcentage_poissons', 'pourcentage_vollailes', 'date_creation'];
}
