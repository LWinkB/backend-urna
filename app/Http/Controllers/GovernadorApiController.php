<?php

namespace App\Http\Controllers;

use App\Models\Governador;
use Illuminate\Http\Request;

class GovernadorApiController extends Controller
{
    protected $model;
    protected $pathCandidate;

    public function __construct(Governador $governador, Request $request)
    {
        $this->model = $governador;
        $this->request = $request;
    }
}
