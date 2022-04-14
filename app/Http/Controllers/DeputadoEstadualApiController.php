<?php

namespace App\Http\Controllers;

use App\Models\DeputadoEstadual;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as image;

class DeputadoEstadualApiController extends Controller
{
    protected $model;
    protected $pathCandidate;

    public function __construct(DeputadoEstadual $deputadoEstadual, Request $request)
    {
        $this->model = $deputadoEstadual;
        $this->request = $request;
    }

    public function updateStateDeputy(Request $request, $id)
    {
        if (!$data = $this->model->find($id)) {
            return response()->json(['error' => 'Usuário não encontrado!'], 404);
        }

        $dataForm = $request->all();

        $photo = $request->imgCandidato;

        if ($request->hasFile('imgCandidato')) {

            $extension = $request->imgCandidato->extension();

            $name = date('His');
            $nameFile = "{$name}.{$extension}";

            $upload = image::make($photo)->resize(177, 236)->save(storage_path("App/public/imagemCandidato/{$nameFile}"));

            if (!$upload) {
                return response()->json(['Error' => 'Falha ao fazer upload'], 500);
            } else {
                $dataForm['imgCandidato'] = $nameFile;
            }
        }

        $data->update($dataForm);

        return response()->json($data);

    }
}
