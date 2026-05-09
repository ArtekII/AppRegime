<?php

namespace App\Models;

use CodeIgniter\Model;

class ActiviteModel extends Model
{
    protected $table            = 'activite_sportive';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['nom', 'calories_brulees_par_heure'];

    protected $validationRules = [
        'nom' => 'required|max_length[255]',
        'calories_brulees_par_heure' => 'required|numeric',
    ];
}
