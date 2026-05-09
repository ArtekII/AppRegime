<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'utilisateur';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['email', 'nom', 'mot_de_passe', 'genre', 'taille', 'poids', 'role', 'solde'];

    protected $validationRules = [
        'nom'          => 'required|max_length[255]',
        'email'        => 'required|valid_email|max_length[255]|is_unique[utilisateur.email,id,{id}]',
        'mot_de_passe' => 'required|max_length[255]',
        'genre'        => 'required|in_list[Homme,Femme,Autre]',
        'taille'       => 'required|numeric',
        'poids'        => 'required|numeric',
    ];
}
