<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\AbonnementGoldModel;

class PaiementController extends BaseController
{
    protected $userModel;
    protected $abonnementGoldModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->abonnementGoldModel = new AbonnementGoldModel();
    }

    public function achatGold()
    {
        $prixGold = 9.99;
        return view('paiement/achat_gold', ['prixGold' => $prixGold]);
    }

    public function traiterAchat()
    {
        $utilisateurId = $this->request->getPost('utilisateur_id');
        $methode = $this->request->getPost('methode_paiement');
        $montant = $this->request->getPost('montant');

        $utilisateur = $this->userModel->find($utilisateurId);
        if (!$utilisateur) {
            return redirect()->back()->with('error', 'Utilisateur non trouvé');
        }

        $prixGold = 9.99;
        if ($montant != $prixGold) {
            return redirect()->back()->with('error', 'Montant incorrect');
        }

        if ($methode === 'carte') {
            $numeroCarte = $this->request->getPost('numero_carte');
            $cvv = $this->request->getPost('cvv');
            $dateExpiration = $this->request->getPost('date_expiration');

            if (!$this->validerCarte($numeroCarte, $cvv, $dateExpiration)) {
                return redirect()->back()->with('error', 'Données de carte invalides');
            }
        } elseif ($methode === 'paypal') {
            $emailPaypal = $this->request->getPost('email_paypal');
            if (!filter_var($emailPaypal, FILTER_VALIDATE_EMAIL)) {
                return redirect()->back()->with('error', 'Email PayPal invalide');
            }
        } elseif ($methode === 'portefeuille') {
            $soldeActuel = $utilisateur['solde'];
            if ($soldeActuel < $prixGold) {
                return redirect()->back()->with('error', 'Solde insuffisant');
            }
            $this->userModel->update($utilisateurId, ['solde' => $soldeActuel - $prixGold]);
        } else {
            return redirect()->back()->with('error', 'Méthode de paiement invalide');
        }

        $this->abonnementGoldModel->insert([
            'utilisateur_id' => $utilisateurId,
            'prix' => $prixGold,
        ]);

        return redirect()->to('/')->with('success', 'Abonnement Gold activé avec succès');
    }

    protected function validerCarte($numero, $cvv, $dateExp)
    {
        if (strlen($numero) < 13 || strlen($numero) > 19) {
            return false;
        }
        if (strlen($cvv) < 3 || strlen($cvv) > 4) {
            return false;
        }
        return true;
    }
}
