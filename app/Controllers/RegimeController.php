<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AbonnementGoldModel;
use App\Models\AchatRegimeModel;
use App\Models\PrixRegimeModel;
use App\Models\RegimeModel;
use App\Models\UserModel;

class RegimeController extends BaseController
{
    private const GOLD_DISCOUNT_RATE = 0.15;

    protected RegimeModel $regimeModel;

    public function __construct()
    {
        $this->regimeModel = new RegimeModel();
    }

    public function index()
    {
        return view('regimes/index', [
            'regimes' => $this->regimeModel->findAll(),
        ]);
    }

    public function create()
    {
        return view('regimes/create');
    }

    public function store()
    {
        $data = $this->getRegimeDataFromRequest();

        if (! $this->regimeModel->insert($data)) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode(' ', $this->regimeModel->errors()) ?: 'Creation impossible.');
        }

        return redirect()->to(site_url('regime'))->with('success', 'Regime cree avec succes.');
    }

    public function show(int $id)
    {
        $regime = $this->regimeModel->find($id);

        if ($regime === null) {
            return redirect()->to(site_url('regime'))->with('error', 'Regime non trouve.');
        }

        return view('regimes/show', ['regime' => $regime]);
    }

    public function edit(int $id)
    {
        $regime = $this->regimeModel->find($id);

        if ($regime === null) {
            return redirect()->to(site_url('regime'))->with('error', 'Regime non trouve.');
        }

        return view('regimes/edit', ['regime' => $regime]);
    }

    public function update(int $id)
    {
        if ($this->regimeModel->find($id) === null) {
            return redirect()->to(site_url('regime'))->with('error', 'Regime non trouve.');
        }

        if (! $this->regimeModel->update($id, $this->getRegimeDataFromRequest())) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode(' ', $this->regimeModel->errors()) ?: 'Modification impossible.');
        }

        return redirect()->to(site_url('regime'))->with('success', 'Regime modifie avec succes.');
    }

    public function delete(int $id)
    {
        if ($this->regimeModel->find($id) === null) {
            return redirect()->to(site_url('regime'))->with('error', 'Regime non trouve.');
        }

        $this->regimeModel->delete($id);

        return redirect()->to(site_url('regime'))->with('success', 'Regime supprime avec succes.');
    }

    public function details(int $id)
    {
        $prixRegimeModel = new PrixRegimeModel();
        $regime = $this->regimeModel->find($id);

        if ($regime === null) {
            return redirect()->back()->with('error', 'Regime introuvable.');
        }

        return view('regimes/details', [
            'regime' => $regime,
            'prixRegimes' => $prixRegimeModel->getPrixByRegimeId($id),
            'isGold' => $this->userHasGold((int) session()->get('user_id')),
            'goldDiscountRate' => self::GOLD_DISCOUNT_RATE,
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

        $prixInitial = (float) $prixRegime['prix'];
        $isGold = $this->userHasGold($userId);
        $prix = $this->applyGoldDiscount($prixInitial, $isGold);
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

    private function userHasGold(int $userId): bool
    {
        if ($userId <= 0) {
            return false;
        }

        return (new AbonnementGoldModel())
            ->where('utilisateur_id', $userId)
            ->first() !== null;
    }

    private function applyGoldDiscount(float $price, bool $isGold): float
    {
        if (! $isGold) {
            return $price;
        }

        return round($price * (1 - self::GOLD_DISCOUNT_RATE), 2);
    }

    private function getRegimeDataFromRequest(): array
    {
        return [
            'nom' => $this->request->getPost('nom'),
            'pourcentage_viandes' => $this->request->getPost('pourcentage_viandes'),
            'pourcentage_poissons' => $this->request->getPost('pourcentage_poissons'),
            'pourcentage_volailles' => $this->request->getPost('pourcentage_volailles'),
        ];
    }
}
