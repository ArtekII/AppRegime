<?php

namespace App\Controllers;

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
}
