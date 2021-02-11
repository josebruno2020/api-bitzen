<?php
namespace App\Http\Services;

use App\Models\{Avaliacao, Categoria, Filme, User};

class FilmeServices{

    public function avaliacao(int $avaliacao, User $usuario, Filme $filme)
    {
        //Verificando se o usuário já avaliou esse filme;
        $avaliado = Avaliacao::query()
            ->where('user_id', $usuario->id)
            ->where('filme_id', $filme->id)
            ->first();
        if(!is_null($avaliado)){
            return false;
        }
        //Cria a avaliação;
        Avaliacao::create([
        'avaliacao'=> $avaliacao,
        'user_id' =>$usuario->id,
        'filme_id' => $filme->id
        ]);
        return true;
    }

    public function buscaPorNome($busca)
    {
        $filmes = Filme::query()->where('nome', 'like', "%$busca%")->get();
        return $filmes;
    }

    public function buscaPorCategoria($busca)
    {
        $filmes = Filme::query()->whereHas('categorias', function($e) use($busca){
            $e->where('nome', 'like', "%$busca%");
        })->get();

        return $filmes;
    }

    public function buscaPorAtor($busca)
    {
        $filmes = Filme::query()->whereHas('atores', function($e) use($busca){
            $e->where('nome', 'like', "%$busca%");
        })->get();
        return $filmes;
    }
}