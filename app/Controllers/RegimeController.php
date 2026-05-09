<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PrixRegimeModel;
use App\Models\RegimeModel;

class RegimeController extends BaseController
{
    public function details(int $id)
    {
        $regimeModel = new RegimeModel();
        $prixRegimeModel = new PrixRegimeModel();

        $regime = $regimeModel->find($id);

        if ($regime === null) {
            return redirect()->back()->with('error', 'Regime introuvable.');
        }

        return view('regimes/details', [
            'regime' => $regime,
            'prixRegimes' => $prixRegimeModel->getPrixByRegimeId($id),
        ]);
    }
}
