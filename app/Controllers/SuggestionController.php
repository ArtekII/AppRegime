<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class SuggestionController extends BaseController
{
    public function index()
    {
        $objectifsModel = new \App\Models\Objectifs();
        $objectifs = $objectifsModel->findAll();

        return view("suggestions/suggestions", ['objectifs' => $objectifs]);
    }
}
