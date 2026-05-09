<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ActiviteModel;
use App\Models\ActiviteObjectifModel;
use App\Models\ActiviteSportiveModel;

class ActiviteController extends BaseController
{
    protected ActiviteModel $activiteModel;

    public function __construct()
    {
        $this->activiteModel = new ActiviteModel();
    }

    public function index()
    {
        return view('activites/index', [
            'activites' => $this->activiteModel->findAll(),
        ]);
    }

    public function create()
    {
        return view('activites/create');
    }

    public function store()
    {
        if (! $this->activiteModel->insert($this->getActiviteDataFromRequest())) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode(' ', $this->activiteModel->errors()) ?: 'Creation impossible.');
        }

        return redirect()->to(site_url('activite'))->with('success', 'Activite creee avec succes.');
    }

    public function show(int $id)
    {
        $activite = $this->activiteModel->find($id);

        if ($activite === null) {
            return redirect()->to(site_url('activite'))->with('error', 'Activite non trouvee.');
        }

        return view('activites/show', ['activite' => $activite]);
    }

    public function edit(int $id)
    {
        $activite = $this->activiteModel->find($id);

        if ($activite === null) {
            return redirect()->to(site_url('activite'))->with('error', 'Activite non trouvee.');
        }

        return view('activites/edit', ['activite' => $activite]);
    }

    public function update(int $id)
    {
        if ($this->activiteModel->find($id) === null) {
            return redirect()->to(site_url('activite'))->with('error', 'Activite non trouvee.');
        }

        if (! $this->activiteModel->update($id, $this->getActiviteDataFromRequest())) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode(' ', $this->activiteModel->errors()) ?: 'Modification impossible.');
        }

        return redirect()->to(site_url('activite'))->with('success', 'Activite modifiee avec succes.');
    }

    public function delete(int $id)
    {
        if ($this->activiteModel->find($id) === null) {
            return redirect()->to(site_url('activite'))->with('error', 'Activite non trouvee.');
        }

        $this->activiteModel->delete($id);

        return redirect()->to(site_url('activite'))->with('success', 'Activite supprimee avec succes.');
    }

    public function details(int $id)
    {
        $activiteSportiveModel = new ActiviteSportiveModel();
        $activiteObjectifModel = new ActiviteObjectifModel();

        $activite = $activiteSportiveModel->find($id);

        if ($activite === null) {
            return redirect()->back()->with('error', 'Activite introuvable.');
        }

        return view('activites/details', [
            'activite' => $activite,
            'programmes' => $activiteObjectifModel
                ->select(
                    'activite_objectif.*, objectif.type as objectif_type, '
                    . '(activite_sportive.calories_brulees_par_heure * activite_objectif.duree_minutes_par_seance / 60) as calories_par_seance, '
                    . '(activite_sportive.calories_brulees_par_heure * activite_objectif.duree_minutes_par_seance / 60 * activite_objectif.frequence_par_semaine) as calories_par_semaine'
                )
                ->join('objectif', 'objectif.id = activite_objectif.objectif_id')
                ->join('activite_sportive', 'activite_sportive.id = activite_objectif.activite_id')
                ->where('activite_objectif.activite_id', $id)
                ->orderBy('activite_objectif.duree_jours', 'ASC')
                ->findAll(),
        ]);
    }

    private function getActiviteDataFromRequest(): array
    {
        return [
            'nom' => $this->request->getPost('nom'),
            'calories_brulees_par_heure' => $this->request->getPost('calories_brulees_par_heure'),
        ];
    }
}
