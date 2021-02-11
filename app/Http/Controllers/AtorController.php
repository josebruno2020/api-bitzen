<?php

namespace App\Http\Controllers;

use App\Models\Ator;
use Illuminate\Http\Request;

class AtorController extends BaseController
{
    public function __construct()
    {
        $this->entidade = Ator::class;
    }

    /**
     * @OA\Get(
     *      path="/api/atores",
     *      operationId="indexAtor",
     *      tags={"atores"},
     *      summary="Atores cadastrados no sistema",
     *      description="Retorna os atores cadastrados no sistema paginados em 15",
     *      security={ {"bearer_token": {} }},
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
     *          response=401,
     *          description="Não autorizado",
     *      )
     * )
     */
    public function index()
    {
        $atores = Ator::paginate();
        return response()->json($atores, 200);
    }

    /**
     * @OA\Post(
     * path="/api/atores",
     * summary="Cria um ator",
     * description="Método para criar um novo ator no sistema",
     * operationId="storeAtor",
     * tags={"atores"},
     * security={ {"bearer_token": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="Obrigatório nome do autor",
     *    @OA\JsonContent(
     *       required={"nome"},
     *       @OA\Property(property="nome", type="string", format="string", example="bruno")
     *    ),
     * ),
     * @OA\Response(
     *    response=201,
     *    description="Sucesso",
     *    @OA\JsonContent(
     *       @OA\Property(property="mensagem", type="string", example="Novo Ator cadastrado")
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
        $ator = Ator::create($request->all());
        return response()->json($ator, 201);
    }

    /**
     * @OA\Get(
     *      path="/api/atores/{id}",
     *      operationId="showAtor",
     *      tags={"atores"},
     *      summary="Mostra Ator",
     *      description="Retorna ator pelo ID da url",
     *      security={ {"bearer_token": {} }},
     *      @OA\Parameter(
     *          description="ID do ator",
     *          in="path",
     *          name="id",
     *          required=true,
     *          example="1",
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Sucesso",
     *          @OA\JsonContent(
     *          @OA\Property(property="ator", type="object", 
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
    public function show(int $id)
    {
        $ator = $this->entidade::find($id);
        if(is_null($ator)){
            return response()
                ->json([
                    'erro' => 'Ator não encontrado'
                ], 404);
        }
        return response()->json($ator, 200);
    }

    /**
     * @OA\Put(
     * path="/api/atores/{id}",
     * summary="Atualiza Ator",
     * description="Atualiza um ator, de acordo com o ID",
     * operationId="updateAtor",
     * tags={"atores"},
     * security={ {"bearer_token": {} }},
     * @OA\Parameter(
     *          description="ID do ator",
     *          in="path",
     *          name="id",
     *          required=true,
     *          example="1",
     *      ),
     * @OA\RequestBody(
     *    required=true,
     *    description="Nome do ator",
     *    @OA\JsonContent(
     *       required={"nome"},
     *       @OA\Property(property="nome", type="string", format="string", example="bruno"),
     *  ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Sucesso",
     *    @OA\JsonContent(
     *       @OA\Property(property="mensagem", type="string", example="Ator atualizado")
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
     *      path="/api/atores/{id}",
     *      operationId="destroyAtor",
     *      tags={"atores"},
     *      summary="Deleta ator",
     *      description="Deleta ator pelo ID da url",
     *      security={ {"bearer_token": {} }},
     *      @OA\Parameter(
     *          description="ID do ator",
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
     * @OA\Get(
     *      path="/api/atores/{id}/filmes",
     *      operationId="filmesDoAtor",
     *      tags={"atores"},
     *      summary="Ator dos Filmes",
     *      description="Retorna todos os filmes que o ator faz parte",
     *      security={ {"bearer_token": {} }},
     *      @OA\Parameter(
     *          description="ID do ator",
     *          in="path",
     *          name="id",
     *          required=true,
     *          example="1",
     *      ),
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
     *          response=404,
     *          description="Não encontrado",
     *      )
     * )
     */
    public function filmesDoAtor(int $id)
    {
        $ator = Ator::find($id);
        return response()->json($ator->filmes, 200);
    }
}
