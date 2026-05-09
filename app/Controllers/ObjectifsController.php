<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ObjectifModel;
use App\Models\UtilisateurObjectifModel;

class ObjectifsController extends BaseController
{
    private ObjectifModel $objectifsModel;
    private UtilisateurObjectifModel $utilisateursObjectifsModel;

    public function __construct()
    {
        $this->objectifsModel = new ObjectifModel();
        $this->utilisateursObjectifsModel = new UtilisateurObjectifModel();
    }

    public function index()
    {
        $utilisateurId = (int) $this->request->getGet('utilisateur_id');

        return view('objectifs/objectifs', [
            'objectifs' => $this->objectifsModel->getSelectableObjectifs(),
            'utilisateurId' => $utilisateurId > 0 ? $utilisateurId : null,
        ]);
    }

    public function submit()
    {
        $utilisateurId = (int) $this->request->getPost('utilisateur_id');
        $objectifId = (int) $this->request->getPost('objectif');

        $validationRules = [
            'objectif' => 'required|is_natural_no_zero',
        ];

        if ($utilisateurId > 0) {
            $validationRules['utilisateur_id'] = 'required|is_natural_no_zero';
        }

        if (! $this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('error', 'Selection invalide, veuillez reessayer.');
        }

        $objectif = $this->objectifsModel->find($objectifId);

        if ($objectif === null) {
            return redirect()->back()->withInput()->with('error', 'Objectif introuvable.');
        }

        $imcCible = null;
        if ($this->isObjectifImcIdeal($objectif)) {
            $imcCible = (float) $this->request->getPost('imc_cible');

            if ($imcCible < 18.5 || $imcCible > 24.9) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Veuillez choisir un IMC cible entre 18.5 et 24.9.');
            }
        }

        if ($utilisateurId > 0) {
            $saved = $this->utilisateursObjectifsModel->setObjectifForUser($utilisateurId, $objectifId, $imcCible);
            if (! $saved) {
                return redirect()->back()->withInput()->with('error', 'Impossible d\'enregistrer l\'objectif.');
            }
        }

        $target = $utilisateurId > 0
            ? site_url('suggestions?objectif_id=' . $objectifId . '&utilisateur_id=' . $utilisateurId)
            : site_url('suggestions?objectif_id=' . $objectifId);

        return redirect()->to($target)
            ->with('success', 'Objectif selectionne: ' . $objectif['type'] . '.');
    }

    private function isObjectifImcIdeal(array $objectif): bool
    {
        return stripos($objectif['type'], 'IMC') !== false;
    }
}
