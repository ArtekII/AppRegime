<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class LoginController extends BaseController
{
    public function index()
    {
        return view('firstPage');
    }

    public function mainPage(){
        return view ('testPage');
    }

       public function process()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $genre = $this ->request->getPost('genre');
        $nom = $this ->request->getPost('nom');
        
        return view('secondPage', [
            'email' => $email,
            'password' => $password,
            'genre' => $genre,
            'nom' => $nom,
        ]);
    }

    public function save()
    {
        $data = [
            'email'        => $this->request->getPost('email'),
            'nom'          => $this->request->getPost('nom'),
            'mot_de_passe' => $this->request->getPost('password'), 
            'genre'        => $this->request->getPost('genre'),
            'taille'       => $this->request->getPost('taille'),
            'poids'        => $this->request->getPost('poids'),
        ];

        $userModel = new \App\Models\UserModel();
        $userModel->insert($data);

        return "Inscription terminée avec succès pour " . esc($data['nom']) . " !";
    }

public function authenticate()
{
    $email = $this->request->getPost('login_email');
    $password = $this->request->getPost('login_password');

    $userModel = new \App\Models\UserModel();
    
    $user = $userModel->where('email', $email)->first();

    if ($user && $user['mot_de_passe'] === $password) {
        $isAdmin = $user['role'] === 'admin';
        
        session()->set([
            'user_id' => $user['id'],
            'user_name' => $user['nom'],
            'user_email' => $user['email'],
            'isAdmin' => $isAdmin,
            'solde' => $user['solde']
        ]);
        
        return view ('testPage');
    } else {
        return redirect()->back()->with('error', 'Email ou mot de passe incorrect.');
    }
}

}
