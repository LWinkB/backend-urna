<?php

namespace App\Http\Controllers;

use App\Models\Presidente;
use Illuminate\Http\Request;

class PresidenteApiController extends Controller
{
    protected $model;
    protected $pathCandidate;

    public function __construct(Presidente $presidente, Request $request)
    {
        $this->model = $presidente;
        $this->request = $request;
    }
}
