<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ActiviteObjectifModel;
use App\Models\ActiviteSportiveModel;

class ActiviteController extends BaseController
{
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
