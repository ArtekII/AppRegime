<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ActiviteModel;

class ActiviteController extends BaseController
{
    protected $activiteModel;

    public function __construct()
    {
        $this->activiteModel = new ActiviteModel();
    }

    public function index()
    {
        $activites = $this->activiteModel->findAll();
        return view('activites/index', ['activites' => $activites]);
    }

    public function create()
    {
        return view('activites/create');
    }

    public function store()
    {
        $data = [
            'nom' => $this->request->getPost('nom'),
            'calories_brulees_par_heure' => $this->request->getPost('calories_brulees_par_heure'),
        ];

        $this->activiteModel->insert($data);
        return redirect()->to('/activite')->with('success', 'Activité créée avec succès');
    }

    public function show($id)
    {
        $activite = $this->activiteModel->find($id);
        if (!$activite) {
            return redirect()->to('/activite')->with('error', 'Activité non trouvée');
        }
        return view('activites/show', ['activite' => $activite]);
    }

    public function edit($id)
    {
        $activite = $this->activiteModel->find($id);
        if (!$activite) {
            return redirect()->to('/activite')->with('error', 'Activité non trouvée');
        }
        return view('activites/edit', ['activite' => $activite]);
    }

    public function update($id)
    {
        $activite = $this->activiteModel->find($id);
        if (!$activite) {
            return redirect()->to('/activite')->with('error', 'Activité non trouvée');
        }

        $data = [
            'nom' => $this->request->getPost('nom'),
            'calories_brulees_par_heure' => $this->request->getPost('calories_brulees_par_heure'),
        ];

        $this->activiteModel->update($id, $data);
        return redirect()->to('/activite')->with('success', 'Activité modifiée avec succès');
    }

    public function delete($id)
    {
        $activite = $this->activiteModel->find($id);
        if (!$activite) {
            return redirect()->to('/activite')->with('error', 'Activité non trouvée');
        }

        $this->activiteModel->delete($id);
        return redirect()->to('/activite')->with('success', 'Activité supprimée avec succès');
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
}
