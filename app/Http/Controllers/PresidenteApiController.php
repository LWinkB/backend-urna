<?php

namespace App\Http\Controllers;

use App\Models\Presidente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as image;


class PresidenteApiController extends Controller
{
    protected $pathCandidate;
    protected $upload = 'imagem';
    public function __construct(Presidente $presidente, Request $request)
    {
        $this->model = $presidente;
        $this->request = $request;

    }

    public function updatePresident(Request $request, $id)
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
