<?php

namespace App\Http\Controllers;

use App\Models\Candidato;
use App\Models\Cargo;
use Illuminate\Http\Request;

class CargoApiController extends Controller
{
    protected $model;
    protected $pathCandidate;


    public function __construct(Cargo $cargos, Request $request)
    {
        $this->model = $cargos;
        $this->request = $request;
    }

    public function candidato($id)
    {

        if (!$data = $this->model->with('candidatos')->Find($id)) {
            return response()->json(['error' => 'Nada foi encontrado'], 404);
        } else {
            return response()->json($data);
        }
    }

}
