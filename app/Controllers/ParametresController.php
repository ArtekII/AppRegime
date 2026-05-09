<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AppSettingModel;
use App\Models\ObjectifModel;
use App\Models\PrixRegimeModel;
use App\Models\RegimeModel;
use App\Models\RegimeObjectifModel;

class ParametresController extends BaseController
{
    private AppSettingModel $settingModel;
    private PrixRegimeModel $prixRegimeModel;
    private RegimeObjectifModel $regimeObjectifModel;
    private ObjectifModel $objectifModel;
    private RegimeModel $regimeModel;

    public function __construct()
    {
        $this->settingModel = new AppSettingModel();
        $this->prixRegimeModel = new PrixRegimeModel();
        $this->regimeObjectifModel = new RegimeObjectifModel();
        $this->objectifModel = new ObjectifModel();
        $this->regimeModel = new RegimeModel();
    }

    public function index()
    {
        return view('parametres/index', [
            'prixGold' => (float) $this->settingModel->getValue('gold_price', '9.99'),
            'regimes' => $this->regimeModel->orderBy('nom', 'ASC')->findAll(),
            'objectifs' => $this->objectifModel->orderBy('id', 'ASC')->findAll(),
            'prixRegimes' => $this->prixRegimeModel
                ->select('prix_regimes.*, regime.nom as regime_nom')
                ->join('regime', 'regime.id = prix_regimes.regime_id')
                ->orderBy('regime.nom', 'ASC')
                ->orderBy('prix_regimes.duree_jours', 'ASC')
                ->findAll(),
            'effetsRegimes' => $this->regimeObjectifModel
                ->select('regime_objectif.*, regime.nom as regime_nom, objectif.type as objectif_type')
                ->join('regime', 'regime.id = regime_objectif.regime_id')
                ->join('objectif', 'objectif.id = regime_objectif.objectif_id')
                ->orderBy('regime.nom', 'ASC')
                ->findAll(),
            'objectifTypes' => [
                'Augmenter son poids',
                'Réduire son poids',
                'Atteindre son IMC idéal',
            ],
        ]);
    }

    public function updateGoldPrice()
    {
        if (! $this->validate(['prix_gold' => 'required|numeric|greater_than[0]'])) {
            return redirect()->back()->withInput()->with('error', 'Prix Gold invalide.');
        }

        $saved = $this->settingModel->setValue('gold_price', (string) $this->request->getPost('prix_gold'));

        return redirect()->back()->with(
            $saved ? 'success' : 'error',
            $saved ? 'Prix Gold mis a jour.' : 'Impossible de sauvegarder le prix Gold. Verifiez la table app_settings.'
        );
    }

    public function storePrixRegime()
    {
        $data = [
            'regime_id' => $this->request->getPost('regime_id'),
            'duree_jours' => $this->request->getPost('duree_jours'),
            'prix' => $this->request->getPost('prix'),
        ];

        if (! $this->prixRegimeModel->insert($data)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->prixRegimeModel->errors()));
        }

        return redirect()->back()->with('success', 'Prix par duree ajoute.');
    }

    public function deletePrixRegime(int $id)
    {
        $this->prixRegimeModel->delete($id);

        return redirect()->back()->with('success', 'Prix par duree supprime.');
    }

    public function storeEffetRegime()
    {
        $data = [
            'regime_id' => $this->request->getPost('regime_id'),
            'objectif_id' => $this->request->getPost('objectif_id'),
            'poids_min' => $this->request->getPost('poids_min'),
            'poids_max' => $this->request->getPost('poids_max'),
            'duree_jours' => $this->request->getPost('duree_jours'),
        ];

        if (! $this->regimeObjectifModel->insert($data)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->regimeObjectifModel->errors()));
        }

        return redirect()->back()->with('success', 'Effet de regime ajoute.');
    }

    public function deleteEffetRegime(int $id)
    {
        $this->regimeObjectifModel->delete($id);

        return redirect()->back()->with('success', 'Effet de regime supprime.');
    }

    public function storeObjectif()
    {
        $type = (string) $this->request->getPost('type');

        if ($this->objectifModel->where('type', $type)->first() !== null) {
            return redirect()->back()->with('error', 'Cet objectif existe deja.');
        }

        if (! $this->objectifModel->insert(['type' => $type])) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->objectifModel->errors()));
        }

        return redirect()->back()->with('success', 'Objectif ajoute.');
    }

    public function deleteObjectif(int $id)
    {
        $this->objectifModel->delete($id);

        return redirect()->back()->with('success', 'Objectif supprime.');
    }
}
