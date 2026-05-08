<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Objectifs;
use App\Models\UtilisateursObjectifsModel;

class ObjectifsController extends BaseController
{
    private Objectifs $objectifsModel;
    private UtilisateursObjectifsModel $utilisateursObjectifsModel;

    public function __construct()
    {
        $this->objectifsModel = new Objectifs();
        $this->utilisateursObjectifsModel = new UtilisateursObjectifsModel();
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
            return redirect()->back()->withInput()->with('error', 'Sélection invalide, veuillez réessayer.');
        }

        $objectif = $this->objectifsModel->find($objectifId);

        if ($objectif === null) {
            return redirect()->back()->withInput()->with('error', 'Objectif introuvable.');
        }

        if ($utilisateurId > 0) {
            $saved = $this->utilisateursObjectifsModel->setObjectifForUser($utilisateurId, $objectifId);
            if (! $saved) {
                return redirect()->back()->withInput()->with('error', 'Impossible d\'enregistrer l\'objectif.');
            }
        }

        $target = $utilisateurId > 0
            ? site_url('objectifs?utilisateur_id=' . $utilisateurId)
            : site_url('objectifs');

        return redirect()->to($target)
            ->with('success', 'Objectif sélectionné: ' . $objectif['type'] . '.');
    }
}
