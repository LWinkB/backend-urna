<?php

namespace App\Http\Controllers;

use App\Models\DeputadoFederal;
use Illuminate\Http\Request;

class DeputadoFederalApiController extends Controller
{
    protected $model;
    protected $pathCandidate;

    public function __construct(DeputadoFederal $deputadoFederal, Request $request)
    {
        $this->model = $deputadoFederal;
        $this->request = $request;
    }
}
