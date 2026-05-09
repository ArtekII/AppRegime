<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class LoginController extends BaseController
{
    public function index()
    {
        return redirect()->to(site_url('connexion'));
    }

    public function login()
    {
        return view('auth/login');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function save()
    {
        $data = [
            'email'        => $this->request->getPost('email'),
            'nom'          => $this->request->getPost('nom'),
            'mot_de_passe' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'genre'        => $this->request->getPost('genre'),
            'taille'       => $this->request->getPost('taille'),
            'poids'        => $this->request->getPost('poids'),
        ];

        $userModel = new UserModel();
        $userId = $userModel->insert($data, true);

        if ($userId === false) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode(' ', $userModel->errors()) ?: 'Inscription impossible pour le moment.');
        }

        $user = $userModel->find($userId);
        $this->connectUser($user);

        return redirect()->to(site_url('accueil'))
            ->with('success', 'Inscription terminee. Bienvenue sur votre page d\'accueil.');
    }

    public function authenticate()
    {
        $email = $this->request->getPost('login_email');
        $password = (string) $this->request->getPost('login_password');

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        $passwordIsValid = $user !== null
            && (
                password_verify($password, $user['mot_de_passe'])
                || hash_equals($user['mot_de_passe'], $password)
            );

        if (! $passwordIsValid) {
            return redirect()->back()->with('error', 'Email ou mot de passe incorrect.');
        }

        $this->connectUser($user);

        return redirect()->to(site_url('accueil'))
            ->with('success', 'Connexion reussie.');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(site_url('connexion'))
            ->with('success', 'Vous etes deconnecte.');
    }

    private function connectUser(?array $user): void
    {
        if ($user === null) {
            return;
        }

        session()->set([
            'is_logged_in' => true,
            'user_id' => (int) $user['id'],
            'user_name' => $user['nom'],
            'user_role' => $user['role'],
            'solde' => $user['solde'],
        ]);
    }
}
