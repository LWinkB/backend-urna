<?php

namespace App\Http\Controllers;

use App\Models\Senador;
use Illuminate\Http\Request;

class SenadorApiController extends Controller
{
    protected $model;
    protected $pathCandidate;

    public function __construct(Senador $senador, Request $request)
    {
        $this->model = $senador;
        $this->request = $request;
    }
}
