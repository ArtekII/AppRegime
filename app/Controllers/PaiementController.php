<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AbonnementGoldModel;
use App\Models\AppSettingModel;
use App\Models\UserModel;

class PaiementController extends BaseController
{
    protected UserModel $userModel;
    protected AbonnementGoldModel $abonnementGoldModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->abonnementGoldModel = new AbonnementGoldModel();
    }

    public function achatGold()
    {
        $prixGold = $this->getPrixGold();

        return view('paiement/achat_gold', [
            'prixGold' => $prixGold,
            'utilisateur' => $this->userModel->find((int) session()->get('user_id')),
        ]);
    }

    public function traiterAchat()
    {
        $utilisateurId = (int) session()->get('user_id');
        $methode = $this->request->getPost('methode_paiement');
        $montant = (float) $this->request->getPost('montant');
        $prixGold = $this->getPrixGold();

        $utilisateur = $this->userModel->find($utilisateurId);
        if ($utilisateur === null) {
            return redirect()->to(site_url('connexion'))->with('error', 'Utilisateur non trouve.');
        }

        if (abs($montant - $prixGold) > 0.001) {
            return redirect()->back()->with('error', 'Montant incorrect.');
        }

        $abonnementExistant = $this->abonnementGoldModel
            ->where('utilisateur_id', $utilisateurId)
            ->first();

        if ($abonnementExistant !== null) {
            return redirect()->back()->with('error', 'Vous avez deja un abonnement Gold actif.');
        }

        if ($methode === 'carte') {
            if (! $this->validerCarte(
                (string) $this->request->getPost('numero_carte'),
                (string) $this->request->getPost('cvv'),
                (string) $this->request->getPost('date_expiration')
            )) {
                return redirect()->back()->with('error', 'Donnees de carte invalides.');
            }
        } elseif ($methode === 'paypal') {
            $emailPaypal = (string) $this->request->getPost('email_paypal');
            if (! filter_var($emailPaypal, FILTER_VALIDATE_EMAIL)) {
                return redirect()->back()->with('error', 'Email PayPal invalide.');
            }
        } elseif ($methode === 'portefeuille') {
            $soldeActuel = (float) $utilisateur['solde'];
            if ($soldeActuel < $prixGold) {
                return redirect()->back()->with('error', 'Solde insuffisant.');
            }

            $this->userModel->update($utilisateurId, ['solde' => $soldeActuel - $prixGold]);
            session()->set('solde', $soldeActuel - $prixGold);
        } else {
            return redirect()->back()->with('error', 'Methode de paiement invalide.');
        }

        $this->abonnementGoldModel->insert([
            'utilisateur_id' => $utilisateurId,
            'prix' => $prixGold,
        ]);

        return redirect()->to(site_url('accueil'))->with('success', 'Abonnement Gold active avec succes.');
    }

    protected function validerCarte(string $numero, string $cvv, string $dateExp): bool
    {
        return strlen($numero) >= 13
            && strlen($numero) <= 19
            && strlen($cvv) >= 3
            && strlen($cvv) <= 4
            && $dateExp !== '';
    }

    private function getPrixGold(): float
    {
        return (float) (new AppSettingModel())->getValue('gold_price', '9.99');
    }
}
