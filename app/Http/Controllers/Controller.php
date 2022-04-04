<?php

namespace App\Http\Controllers;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as image;


class Controller extends BaseController
{
    protected $model;
    protected $pathCandidate = 'imagemCandidato';


    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //Lista de dados da tabela
    public function index()
    {
        $data = $this->model->all();

        return response()->json($data);
    }

    //Salvar registros na tabela

    public function store(Request $request)
    {
        $this->validate($request, $this->model->rules());

        $dataForm = $request->all();

        if ($request->hasFile('imgCandidato') && $request->file('imgCandidato')->isValid()) {

            $extension = $request->imgCandidato->extension();

            $name = uniqid(date('His'));

            $nameFile = "{$name}.{$extension}";
                dd($request);
            $upload = image::make($dataForm['imgCandidato'])->resize(177, 236)->save(storage_path("App/public/{$this->pathCandidate}/{$nameFile}"));

            if (!$upload) {
                return response()->json(['Error' => 'Falha ao fazer upload'], 500);
            } else {
                $dataForm['imgCandidato'] = $nameFile;
            }
        }

        $data = $this->model->create($dataForm);

        return response()->json($data, 201);

    }


    //Mostra um item específico
    public function show($numero)
    {
        $candidate = $this->model::where('numero', $numero)->first();

        if ($candidate == []) {
            return response()->json([], 200);
        } else {
            return response()->json($candidate);
        }
    }

    public function update($id)
    {
        $qtdVotos = $this->model::select('qtdVotos')->where('id', $id)->first();

        $this->model::where('id', $id)->update(['qtdVotos' => $qtdVotos['qtdVotos'] + 1]);
    }

    public function destroy($id)
    {
        if (!$data = $this->model->find($id)) {
            return response()->json(['Error' => 'Nada foi encontrado'], 404);
        }
        if ($data->imgCandidato) {
            Storage::disk('public')->delete("/$this->pathCandidate/$data->imgCandidato");
        }
        $data->delete();
        return response()->json(['success' => 'Deletado com sucesso!']);
    }

}
