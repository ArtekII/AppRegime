<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ObjectifModel;
use App\Models\RegimeObjectifModel;

class SuggestionController extends BaseController
{
    public function index()
    {
        $objectifsModel = new ObjectifModel();
        $objectifs = $objectifsModel->findAll();
        $objectifId = (int) $this->request->getGet('objectif_id');
        $suggestions = [];

        if ($objectifId > 0) {
            $suggestionsModel = new RegimeObjectifModel();
            $suggestions = $suggestionsModel->getRegimeAndActiviteByObjectifId($objectifId);
        }

        return view('suggestions/suggestions', [
            'objectifs' => $objectifs,
            'objectifId' => $objectifId,
            'suggestions' => $suggestions,
        ]);
    }
}
