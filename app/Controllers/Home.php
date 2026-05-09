<?php

namespace App\Controllers;

use App\Models\UtilisateurObjectifModel;
use App\Models\UserModel;

class Home extends BaseController
{
    public function index(): string
    {
        $userId = (int) session()->get('user_id');
        $user = (new UserModel())->find($userId);
        $utilisateurObjectif = null;

        if ($user !== null) {
            $utilisateurObjectif = (new UtilisateurObjectifModel())
                ->where('utilisateur_id', $userId)
                ->orderBy('id', 'DESC')
                ->first();

            session()->set([
                'user_name' => $user['nom'],
                'user_role' => $user['role'],
                'solde' => $user['solde'],
            ]);
        }

        return view('page_accueil', [
            'utilisateur' => $user,
            'utilisateurObjectif' => $utilisateurObjectif,
        ]);
    }
}
