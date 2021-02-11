<?php

namespace App\Http\Controllers;

use App\Http\Services\FilmeServices;
use App\Models\{Ator, Filme, Categoria};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FilmeController extends BaseController
{
    public function __construct()
    {
        $this->entidade = Filme::class;
    }
    /**
     * @OA\Get(
     *      path="/api/filmes",
     *      operationId="indexFilme",
     *      tags={"filmes"},
     *      security={{"bearer_token":{}}},
     *      summary="Filmes cadastrados no sistema",
     *      description="Retorna os filmes cadastrados no sistema paginados em 15",
     *      @OA\Response(
     *          response=200,
     *          description="Sucesso",
     *          @OA\JsonContent(
     *          @OA\Property(property="filmes", type="object", 
     *          ref="#/components/schemas/Filme"),
     *          ),
     *          
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Não autorizado",
     *      )
     * )
     */
    public function index()
    {
        $recursos = $this->entidade::paginate();
        return response()->json($recursos, 200);
    }

    /**
     * @OA\Post(
     * path="/api/filmes",
     * summary="Cria um Filme",
     * description="Método para criar um novo Filme no sistema",
     * operationId="storeFilme",
     * tags={"filmes"},
     * security={ {"bearer_token": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="Obrigatório nome do Filme",
     *    @OA\JsonContent(
     *       required={"nome"},
     *       @OA\Property(property="nome", type="string", format="string", example="Vingadores")
     *    ),
     * ),
     * @OA\Response(
     *    response=201,
     *    description="Sucesso",
     *    @OA\JsonContent(
     *       @OA\Property(property="mensagem", type="string", example="Novo Filme cadastrado")
     *        )
     *     ),
     * @OA\Response(
     *    response=400,
     *    description="Erro nos parâmetros",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Informe todos os dados obrigatórios")
     *        )
     *     )
     * )
     */
    public function store(Request $request)
    {
        if(is_null($request->nome)){
            return response()->json(['erro' => 'Campo Nome é obrigatório'], 400);
        }
        $recurso = $this->entidade::create($request->all());
        return response()->json($recurso, 201);
    }

    /**
     * @OA\Get(
     *      path="/api/filmes/{id}",
     *      operationId="showFilme",
     *      tags={"filmes"},
     *      summary="Mostra Filme",
     *      description="Retorna Filme pelo ID da url",
     *      security={ {"bearer_token": {} }},
     *      @OA\Parameter(
     *          description="ID do Filme",
     *          in="path",
     *          name="id",
     *          required=true,
     *          example="1",
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Sucesso",
     *          @OA\JsonContent(
     *          @OA\Property(property="filme", type="object", 
     *          ref="#/components/schemas/Filme"),
     *          ),
     *          
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Não encontrado",
     *      )
     * )
     */
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

    /**
     * @OA\Put(
     * path="/api/filmes/{id}",
     * summary="Atualiza Filme",
     * description="Atualiza um Filme, de acordo com o ID",
     * operationId="updateFilme",
     * tags={"filmes"},
     * security={ {"bearer_token": {} }},
     * @OA\Parameter(
     *          description="ID do Filme",
     *          in="path",
     *          name="id",
     *          required=true,
     *          example="1",
     *      ),
     * @OA\RequestBody(
     *    required=true,
     *    description="Nome do Filme",
     *    @OA\JsonContent(
     *       required={"nome"},
     *       @OA\Property(property="nome", type="string", format="string", example="Vingadores")
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Sucesso",
     *    @OA\JsonContent(
     *       @OA\Property(property="mensagem", type="string", example="Filme atualizado")
     *        )
     *     ),
     * @OA\Response(
     *    response=400,
     *    description="Erro nos parâmetros",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Informe todos os dados obrigatórios")
     *        )
     *     )
     * )
     */
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

    /**
     * @OA\Delete(
     *      path="/api/filmes/{id}",
     *      operationId="destroyFilme",
     *      tags={"filmes"},
     *      summary="Deleta Filme",
     *      description="Deleta Filme pelo ID da url",
     *      security={ {"bearer_token": {} }},
     *      @OA\Parameter(
     *          description="ID do Filme",
     *          in="path",
     *          name="id",
     *          required=true,
     *          example="1",
     *      ),
     *     @OA\Response(
     *    response=204,
     *    description="Sucesso",
     *    @OA\JsonContent(
     *       @OA\Property(property="mensagem", type="string", example="Sem conteúdo")
     *        )
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="Usuário não encontrado",
     *      )
     * )
     */
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

    /**
     * @OA\Post(
     * path="/api/filmes/{id}/categoria/{id_categoria}",
     * summary="Categorizar um filme",
     * description="Colocar uma categoria em um filme",
     * operationId="categorizar",
     * tags={"filmes"},
     * security={ {"bearer_token": {} }},
     * @OA\Parameter(
     *          description="ID do Filme",
     *          in="path",
     *          name="id",
     *          required=true,
     *          example="1",
     *      ),
     * @OA\Parameter(
     *          description="ID da Categoria",
     *          in="path",
     *          name="id_categoria",
     *          required=true,
     *          example="1",
     *      ),
     * @OA\Response(
     *    response=200,
     *    description="Sucesso",
     *    @OA\JsonContent(
     *       @OA\Property(property="mensagem", type="string", example="Filme Categorizado")
     *        )
     *     ),
     * @OA\Response(
     *    response=404,
     *    description="Não autorizado",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Parâmetros não encontrados")
     *        )
     *     )
     * )
     */
    public function categorizar(int $id, int $id_categoria, Request $request)
    {
        $categoria = Categoria::find($id_categoria);
        $categoria->filmes()->sync($id);
        return response()->json("Filme Categorizado!", 200);
    }

    /**
     * @OA\Post(
     * path="/api/filmes/{id}/ator/{id_ator}",
     * summary="Coloca um ator em um filme",
     * description="Coloca um ator em um filme",
     * operationId="colocarAtor",
     * tags={"filmes"},
     * security={ {"bearer_token": {} }},
     * @OA\Parameter(
     *          description="ID do Filme",
     *          in="path",
     *          name="id",
     *          required=true,
     *          example="1",
     *      ),
     * @OA\Parameter(
     *          description="ID do Ator",
     *          in="path",
     *          name="id_ator",
     *          required=true,
     *          example="1",
     *      ),
     * @OA\Response(
     *    response=200,
     *    description="Sucesso",
     *    @OA\JsonContent(
     *       @OA\Property(property="mensagem", type="string", example="Ator inserido no filme")
     *        )
     *     ),
     * @OA\Response(
     *    response=404,
     *    description="Não autorizado",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Parâmetros não encontrados")
     *        )
     *     )
     * )
     */
    public function colocarAtor(int $id, int $id_ator, Request $request)
    {
        $ator = Ator::find($id_ator);
        $ator->filmes()->sync($id);
        return response()->json("$ator->nome inserido no Filme", 200);
    }

    /**
     * @OA\Post(
     * path="/api/filmes/avaliar/{id}",
     * summary="Avalia um filme",
     * description="Usuário avalia um filme com uma nota de 1 a 5; O id do usuário resgatamos conforme o token, usando o Auth::user()",
     * operationId="avaliar",
     * tags={"filmes"},
     * security={ {"bearer_token": {} }},
     * @OA\Parameter(
     *          description="ID do Filme",
     *          in="path",
     *          name="id",
     *          required=true,
     *          example="1",
     *      ),
     * @OA\Response(
     *    response=200,
     *    description="Sucesso",
     *    @OA\JsonContent(
     *       @OA\Property(property="mensagem", type="string", example="Ator inserido no filme")
     *        )
     *     ),
     * @OA\Response(
     *    response=401,
     *    description="Não Autorizado",
     *    @OA\JsonContent(
     *       @OA\Property(property="mensagem", type="string", example="Você já avaliou esse filme")
     *        )
     *     ),
     * 
     * @OA\Response(
     *    response=404,
     *    description="Não autorizado",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Parâmetros não encontrados")
     *        )
     *     )
     * )
     */
    public function avaliar(int $id, Request $request, FilmeServices $filmeServices)
    {
        $usuario = Auth::user();
        $filme = Filme::find($id);
        //Validando o número para a avaliação;
        if($request->avaliacao > 5 || $request->avaliacao < 1){
            return response()->json("Número inválido para avaliação", 401);
        }
        if($filmeServices->avaliacao($request->avaliacao,$usuario,$filme) == false){
            return response()->json("Você já avaliou esse filme!", 401);
        }
        
        return response()
            ->json("Filme $filme->nome avaliado por $usuario->nome", 200);
    }

    /**
     * @OA\Get(
     *      path="/api/filmes/{id}/atores",
     *      operationId="atoresFilme",
     *      tags={"filmes"},
     *      summary="Atores do Filme",
     *      description="Retorna os atores que o filme tem",
     *      security={ {"bearer_token": {} }},
     *      @OA\Parameter(
     *          description="ID do filme",
     *          in="path",
     *          name="id",
     *          required=true,
     *          example="1",
     *          @OA\Schema(
     *            type="integer",
     *            format="int64"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Sucesso",
     *          @OA\JsonContent(
     *          @OA\Property(property="atores", type="object", 
     *          ref="#/components/schemas/Ator"),
     *          ),
     *          
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Não encontrado",
     *      )
     * )
     */
    public function atoresFilme(int $id)
    {
        $filme = Filme::find($id);
        return response()->json($filme->atores, 200);
    }

    /**
     * @OA\Get(
     *      path="/api/filmes/{id}/categorias",
     *      operationId="categoriasFilme",
     *      tags={"filmes"},
     *      summary="Categorias do Filme",
     *      description="Retorna as categorias que o filme pertence",
     *      security={ {"bearer_token": {} }},
     *      @OA\Parameter(
     *          description="ID do filme",
     *          in="path",
     *          name="id",
     *          required=true,
     *          example="1",
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Sucesso",
     *          @OA\JsonContent(
     *          @OA\Property(property="categorias", type="object", 
     *          ref="#/components/schemas/Categoria"),
     *          ),
     *          
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Não encontrado",
     *      )
     * )
     */
    public function categoriasFilme(int $id)
    {
        $filme = Filme::find($id);
        return response()->json($filme->categorias, 200);
    }

    /**
     * @OA\Post(
     * path="/api/buscar",
     * summary="Filtra os filmes",
     * description="Filtra os filmes de acordo com os parâmetros passados; Filtro (inteiro) e Busca (string)",
     * operationId="search",
     * tags={"filmes"},
     * security={ {"bearer_token": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="Primeiro parâmetro indica tipo de filtro que será feita a busca, sendo 1 = nome do filme; 2 = nome da categoria; 3 = nome do ator; Sempre será retornado os filmes paginados",
     *    @OA\JsonContent(
     *       required={"filtro","busca"},
     *       @OA\Property(property="filtro", type="integer", format="int", example="1"),
     *       @OA\Property(property="busca", type="string", format="string", example="Vingadores"),
     *    ),
     * ),
     * @OA\Response(
     *          response=200,
     *          description="Sucesso",
     *          @OA\JsonContent(
     *          @OA\Property(property="filmes", type="object", 
     *          ref="#/components/schemas/Filme"),
     *          ),
     *          
     *       ),
     * @OA\Response(
     *    response=404,
     *    description="Não encontrado",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Erro nos parâmetros")
     *        )
     *     )
     * )
     */
    public function search(FilmeServices $filmeServices,Request $request)
    {
        if($request->filtro == 1){
            $filmes = $filmeServices->buscaPorNome($request->busca);

        } elseif($request->filtro == 2){
            $filmes = $filmeServices->buscaPorCategoria($request->busca);

        }elseif($request->filtro ==  3){
            $filmes = $filmeServices->buscaPorAtor($request->busca);
        } else {
            return response()->json(['erro' => 'Filtro inválido'], 401);
        }
        
        return response()->json($filmes, 200);
    }

    /**
     * @OA\Get(
     *      path="/api/top-avaliados",
     *      operationId="topAvaliados",
     *      tags={"filmes"},
     *      summary="Filmes top Avaliados",
     *      description="Retorna os 10 filmes top avaliados pelos Usuários",
     *      security={ {"bearer_token": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Sucesso",
     *          @OA\JsonContent(
     *          @OA\Property(property="filmes", type="object", 
     *          ref="#/components/schemas/Filme"),
     *          ),
     *          
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Não autorizado",
     *      )
     * )
     */
    public function topAvaliados()
    {
        $filmes = Filme::query()
            ->limit(10)
            ->has('avaliacoes')
            ->withAvg('avaliacoes', 'avaliacao')
            ->orderBy('avaliacoes_avg_avaliacao', 'desc')
            ->get();

        return response()->json($filmes);
    }
}
