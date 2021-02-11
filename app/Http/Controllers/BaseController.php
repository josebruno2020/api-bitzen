<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller{
    protected $entidade;

    public function index()
    {
        $recursos = $this->entidade::paginate();
        return response()->json($recursos, 200);
    }

    public function store(Request $request)
    {
        if(is_null($request->nome)){
            return response()->json(['erro' => 'Campo Nome é obrigatório'], 400);
        }
        $recurso = $this->entidade::create($request->all());
        return response()->json($recurso, 201);
    }

    public function show(int $id)
    {
        $recurso = $this->entidade::find($id);
        if(is_null($recurso)){
            return response()
                ->json([
                    'erro' => 'Recurso não encontrado'
                ], 404);
        }
        return response()->json($recurso, 200);
    }

    public function update(int $id, Request $request)
    {
        if(is_null($request->nome)){
            return response()->json(['erro' => 'Campo Nome é obrigatório'], 400);
        }
        $recurso = $this->entidade::find($id);
        if(is_null($recurso)){
            return response()
                ->json([
                    'erro' => 'Recurso não encontrado'
                ], 404);
        }

        $recurso->update($request->all());
        return response()->json($recurso, 200);
    }

    public function destroy(int $id)
    {
        $qt = $this->entidade::destroy($id);
        if($qt == 0){
            return response()
                ->json([
                    'erro' => 'Recurso não encontrado'
                ], 404);
        }
        return response()->json('', 204);
    }
}