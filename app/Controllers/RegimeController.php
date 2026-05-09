<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AchatRegimeModel;
use App\Models\PrixRegimeModel;
use App\Models\RegimeModel;
use App\Models\UserModel;

class RegimeController extends BaseController
{
    public function details(int $id)
    {
        $regimeModel = new RegimeModel();
        $prixRegimeModel = new PrixRegimeModel();

        $regime = $regimeModel->find($id);

        if ($regime === null) {
            return redirect()->back()->with('error', 'Regime introuvable.');
        }

        return view('regimes/details', [
            'regime' => $regime,
            'prixRegimes' => $prixRegimeModel->getPrixByRegimeId($id),
        ]);
    }

    public function acheter()
    {
        if (! $this->validate([
            'prix_regime_id' => 'required|is_natural_no_zero',
        ])) {
            return redirect()->back()->with('error', 'Selection de regime invalide.');
        }

        $prixRegimeId = (int) $this->request->getPost('prix_regime_id');
        $userId = (int) session()->get('user_id');

        if ($userId <= 0) {
            return redirect()->to(site_url('connexion'))->with('error', 'Veuillez vous connecter.');
        }

        $prixRegimeModel = new PrixRegimeModel();
        $userModel = new UserModel();
        $achatRegimeModel = new AchatRegimeModel();

        $prixRegime = $prixRegimeModel->find($prixRegimeId);
        if ($prixRegime === null) {
            return redirect()->back()->with('error', 'Prix de regime introuvable.');
        }

        $utilisateur = $userModel->find($userId);
        if ($utilisateur === null) {
            return redirect()->to(site_url('connexion'))->with('error', 'Utilisateur introuvable.');
        }

        $prix = (float) $prixRegime['prix'];
        $solde = (float) $utilisateur['solde'];

        if ($prix <= 0) {
            return redirect()->back()->with('error', 'Prix de regime invalide.');
        }

        if ($solde < $prix) {
            return redirect()->back()
                ->with('error', 'Solde insuffisant. Votre solde actuel est de ' . number_format($solde, 2, ',', ' ') . ' Ar.');
        }

        $db = db_connect();
        $db->transStart();

        $nouveauSolde = $solde - $prix;
        $userModel->update($userId, ['solde' => $nouveauSolde]);
        $achatRegimeModel->insert([
            'utilisateur_id' => $userId,
            'prix_regime_id' => $prixRegimeId,
            'montant' => $prix,
        ]);

        $db->transComplete();

        if (! $db->transStatus()) {
            return redirect()->back()->with('error', 'Achat impossible pour le moment.');
        }

        session()->set('solde', $nouveauSolde);

        return redirect()->back()
            ->with('success', 'Regime achete avec succes. Nouveau solde: ' . number_format($nouveauSolde, 2, ',', ' ') . ' Ar.');
    }
}
