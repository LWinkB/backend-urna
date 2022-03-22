<?php

namespace App\Http\Controllers;

use App\Models\DeputadoEstadual;
use Illuminate\Http\Request;

class DeputadoEstadualApiController extends Controller
{
    protected $model;
    protected $pathCandidate;

    public function __construct(DeputadoEstadual $deputadoEstadual, Request $request)
    {
        $this->model = $deputadoEstadual;
        $this->request = $request;
    }
}
