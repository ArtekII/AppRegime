<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ActiviteObjectifModel;
use App\Models\ObjectifModel;
use App\Models\RegimeObjectifModel;
use App\Models\UtilisateurObjectifModel;
use App\Models\UserModel;

class SuggestionController extends BaseController
{
    public function index()
    {
        $objectifsModel = new ObjectifModel();
        $objectifs = $objectifsModel->findAll();
        $objectifId = (int) $this->request->getGet('objectif_id');
        $utilisateurId = (int) ($this->request->getGet('utilisateur_id') ?? session()->get('user_id'));
        $regimes = [];
        $activites = [];
        $utilisateur = null;
        $utilisateurObjectif = null;
        $imc = null;
        $categorieImc = null;
        $imcCible = null;
        $poidsCible = null;
        $imcIdealAtteint = null;
        $ecartImcCible = null;

        if ($utilisateurId > 0) {
            $userModel = new UserModel();
            $utilisateur = $userModel->find($utilisateurId);
            $utilisateurObjectifModel = new UtilisateurObjectifModel();
            $utilisateurObjectif = $utilisateurObjectifModel
                ->where('utilisateur_id', $utilisateurId)
                ->where('objectif_id', $objectifId)
                ->orderBy('id', 'DESC')
                ->first();

            if ($utilisateur !== null) {
                $tailleMetres = (float) $utilisateur['taille'] / 100;
                $poids = (float) $utilisateur['poids'];

                if ($tailleMetres > 0 && $poids > 0) {
                    $imc = round($poids / ($tailleMetres * $tailleMetres), 1);
                    $categorieImc = $this->getCategorieImc($imc);
                }

                if ($tailleMetres > 0 && ! empty($utilisateurObjectif['imc_cible'])) {
                    $imcCible = (float) $utilisateurObjectif['imc_cible'];
                    $poidsCible = round($imcCible * ($tailleMetres * $tailleMetres), 1);

                    if ($imc !== null) {
                        $ecartImcCible = round(abs($imc - $imcCible), 1);
                        $imcIdealAtteint = $ecartImcCible === 0.0;
                    }
                }
            }
        }

        if ($objectifId > 0) {
            $regimeObjectifModel = new RegimeObjectifModel();
            $activiteObjectifModel = new ActiviteObjectifModel();

            $regimes = $regimeObjectifModel->getRegimesByObjectifId($objectifId);
            $activites = $activiteObjectifModel->getActivitesByObjectifId($objectifId);
        }

        return view('suggestions/suggestions', [
            'objectifs' => $objectifs,
            'objectifId' => $objectifId,
            'utilisateurId' => $utilisateurId > 0 ? $utilisateurId : null,
            'utilisateur' => $utilisateur,
            'utilisateurObjectif' => $utilisateurObjectif,
            'imc' => $imc,
            'categorieImc' => $categorieImc,
            'imcCible' => $imcCible,
            'poidsCible' => $poidsCible,
            'imcIdealAtteint' => $imcIdealAtteint,
            'ecartImcCible' => $ecartImcCible,
            'regimes' => $regimes,
            'activites' => $activites,
        ]);
    }

    private function getCategorieImc(float $imc): string
    {
        if ($imc < 18.5) {
            return 'Insuffisance ponderale';
        }

        if ($imc < 25) {
            return 'Corpulence normale';
        }

        if ($imc < 30) {
            return 'Surpoids';
        }

        return 'Obesite';
    }
}
