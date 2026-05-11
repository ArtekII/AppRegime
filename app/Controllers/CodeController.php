<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CodeHistoriqueModel;
use App\Models\CodeModel;
use App\Models\UserModel;

class CodeController extends BaseController
{
    public function index()
    {
        $codeModel = new CodeModel();
        $codes = $codeModel->findAll();

        return view('code/form', [
            'codes' => $codes,
        ]);
    }

    public function useForm()
    {
        $codeModel = new CodeModel();

        return view('code/use', [
            'codes' => $codeModel->where('utilise', 0)->findAll(),
        ]);
    }

    public function store()
    {
        $data = [
            'code' => $this->request->getPost('code'),
            'montant' => $this->request->getPost('montant'),
        ];

        $codeModel = new CodeModel();

        if (! $codeModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $codeModel->errors());
        }

        return redirect()->to(base_url('code'))->with('success', 'Code montant enregistre avec succes.');
    }

    public function update(int $id)
    {
        $codeModel = new CodeModel();

        if ($codeModel->find($id) === null) {
            return redirect()->to(site_url('code'))->with('error', 'Code introuvable.');
        }

        $data = [
            'code' => $this->request->getPost('code'),
            'montant' => $this->request->getPost('montant'),
            'utilise' => $this->request->getPost('utilise') ? 1 : 0,
        ];

        if (! $codeModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $codeModel->errors());
        }

        return redirect()->to(site_url('code'))->with('success', 'Code modifie avec succes.');
    }

    public function delete(int $id)
    {
        $codeModel = new CodeModel();

        if ($codeModel->find($id) === null) {
            return redirect()->to(site_url('code'))->with('error', 'Code introuvable.');
        }

        $codeModel->delete($id);

        return redirect()->to(site_url('code'))->with('success', 'Code supprime avec succes.');
    }

    public function useCode()
    {
        $codeId = (int) $this->request->getPost('code_id');
        $userId = (int) session()->get('user_id');

        if ($codeId <= 0 || $userId <= 0) {
            return redirect()->back()->with('error', 'Code ou utilisateur invalide.');
        }

        $codeModel = new CodeModel();
        $codeHistoriqueModel = new CodeHistoriqueModel();
        $userModel = new UserModel();

        $code = $codeModel->find($codeId);
        if (! $code) {
            return redirect()->back()->with('error', 'Code non trouve.');
        }

        $user = $userModel->find($userId);
        if (! $user) {
            return redirect()->back()->with('error', 'Utilisateur non trouve.');
        }

        $newSolde = $user['solde'] + $code['montant'];
        $userModel->update($userId, ['solde' => $newSolde]);
        session()->set('solde', $newSolde);

        $codeHistoriqueModel->insert([
            'code_id' => $codeId,
            'utilisateur_id' => $userId,
            'utilise' => 1,
        ]);

        $codeModel->update($codeId, ['utilise' => 1]);

        return redirect()->to(base_url('accueil'))
            ->with('success', 'Code utilise avec succes. Montant ajoute: ' . $code['montant'] . ' Ar.');
    }
}
