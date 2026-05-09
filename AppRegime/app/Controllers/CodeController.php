<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class CodeController extends BaseController
{
    public function index()
    {
        $codeModel = new \App\Models\Code();
        $codes = $codeModel->findAll();

        return view('code/form.php', [
            'codes' => $codes,
        ]);
    }

    public function store()
    {
        $data = [
            'code' => $this->request->getPost('code'),
            'montant' => $this->request->getPost('montant'),
        ];

        $codeModel = new \App\Models\Code();

        if (! $codeModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $codeModel->errors());
        }

        return redirect()->to(base_url('code'))->with('success', 'Code montant enregistre avec succes.');
    }

    public function use_code()
    {
        $code_id = $this->request->getPost('code_id');
        $user_id = session()->get('user_id');

        if (!$code_id || !$user_id) {
            return redirect()->back()->with('error', 'Code ou utilisateur invalide.');
        }

        $codeModel = new \App\Models\Code();
        $codeHistoriqueModel = new \App\Models\CodeHistorique();
        $userModel = new \App\Models\UserModel();

        // Fetch le code_montant
        $code = $codeModel->find($code_id);
        if (!$code) {
            return redirect()->back()->with('error', 'Code non trouvé.');
        }

        // Fetch l'utilisateur
        $user = $userModel->find($user_id);
        if (!$user) {
            return redirect()->back()->with('error', 'Utilisateur non trouvé.');
        }

        // Ajoute le montant au solde
        $newSolde = $user['solde'] + $code['montant'];
        $userModel->update($user_id, ['solde' => $newSolde]);

        // Crée un enregistrement dans l'historique
        $codeHistoriqueModel->insert([
            'code_id' => $code_id,
            'utilisateur_id' => $user_id,
            'utilise' => 1,
        ]);

        // Marque le code comme utilisé (au lieu de le supprimer)
        $codeModel->update($code_id, ['utilise' => 1]);

        return redirect()->to(base_url('code'))->with('success', 'Code utilisé avec succès! Montant : ' . $code['montant'] . ' € ajouté.');
    }
}
