<?php

namespace App\Controllers;

use App\Models\AchatRegimeModel;
use App\Models\PrixRegimeModel;
use App\Models\UserModel;

use App\Controllers\BaseController;
use App\Models\RegimeModel;

class RegimeController extends BaseController
{
    protected $regimeModel;

    public function __construct()
    {
        $this->regimeModel = new RegimeModel();
    }

    public function index()
    {
        $regimes = $this->regimeModel->findAll();
        return view('regimes/index', ['regimes' => $regimes]);
    }

    public function create()
    {
        return view('regimes/create');
    }

    public function store()
    {
        $data = [
            'nom' => $this->request->getPost('nom'),
            'variation_poids' => $this->request->getPost('variation_poids'),
            'duree' => $this->request->getPost('duree'),
            'prix' => $this->request->getPost('prix'),
            'pourcentage_viandes' => $this->request->getPost('pourcentage_viandes'),
            'pourcentage_poissons' => $this->request->getPost('pourcentage_poissons'),
            'pourcentage_vollailes' => $this->request->getPost('pourcentage_vollailes'),
        ];

        $this->regimeModel->insert($data);
        return redirect()->to('/regime')->with('success', 'Régime créé avec succès');
    }

    public function show($id)
    {
        $regime = $this->regimeModel->find($id);
        if (!$regime) {
            return redirect()->to('/regime')->with('error', 'Régime non trouvé');
        }
        return view('regimes/show', ['regime' => $regime]);
    }

    public function edit($id)
    {
        $regime = $this->regimeModel->find($id);
        if (!$regime) {
            return redirect()->to('/regime')->with('error', 'Régime non trouvé');
        }
        return view('regimes/edit', ['regime' => $regime]);
    }

    public function update($id)
    {
        $regime = $this->regimeModel->find($id);
        if (!$regime) {
            return redirect()->to('/regime')->with('error', 'Régime non trouvé');
        }

        $data = [
            'nom' => $this->request->getPost('nom'),
            'variation_poids' => $this->request->getPost('variation_poids'),
            'duree' => $this->request->getPost('duree'),
            'prix' => $this->request->getPost('prix'),
            'pourcentage_viandes' => $this->request->getPost('pourcentage_viandes'),
            'pourcentage_poissons' => $this->request->getPost('pourcentage_poissons'),
            'pourcentage_vollailes' => $this->request->getPost('pourcentage_vollailes'),
        ];

        $this->regimeModel->update($id, $data);
        return redirect()->to('/regime')->with('success', 'Régime modifié avec succès');
    }

    public function delete($id)
    {
        $regime = $this->regimeModel->find($id);
        if (!$regime) {
            return redirect()->to('/regime')->with('error', 'Régime non trouvé');
        }

        $this->regimeModel->delete($id);
        return redirect()->to('/regime')->with('success', 'Régime supprimé avec succès');
    }

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
