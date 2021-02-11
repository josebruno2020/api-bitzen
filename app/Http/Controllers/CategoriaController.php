<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Filme;
use Illuminate\Http\Request;

class CategoriaController extends BaseController
{
    public function __construct()
    {
        $this->entidade = Categoria::class;
    }

    /**
     * @OA\Get(
     *      path="/api/categorias",
     *      operationId="indexCategoria",
     *      tags={"categorias"},
     *      summary="Categorias cadastradas no sistema",
     *      description="Retorna as categorias cadastrados no sistema paginados em 15",
     *      security={ {"bearer_token": {} }},
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
     *          response=401,
     *          description="Não autorizado",
     *      )
     * )
     */
    public function index()
    {
        $entidades = $this->entidade::paginate();
        return response()->json($entidades, 200);
    }

    /**
     * @OA\Post(
     * path="/api/categorias",
     * summary="Cria uma categoria",
     * description="Método para criar uma nova categoria no sistema",
     * operationId="storeAtor",
     * tags={"categorias"},
     * security={ {"bearer_token": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="Obrigatório nome da categoria",
     *    @OA\JsonContent(
     *       required={"nome"},
     *       @OA\Property(property="nome", type="string", format="string", example="Ação")
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Sucesso",
     *    @OA\JsonContent(
     *       @OA\Property(property="mensagem", type="string", example="Nova Categoria cadastrada")
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
        $entidade = $this->entidade::create($request->all());
        return response()->json($entidade, 201);
    }

    /**
     * @OA\Get(
     *      path="/api/categorias/{id}",
     *      operationId="showCategoria",
     *      tags={"categorias"},
     *      summary="Mostra Categoria",
     *      description="Retorna categoria pelo ID da url",
     *      security={ {"bearer_token": {} }},
     *      @OA\Parameter(
     *          description="ID da categoria",
     *          in="path",
     *          name="id",
     *          required=true,
     *          example="1",
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Sucesso",
     *          @OA\JsonContent(
     *          @OA\Property(property="categoria", type="object", 
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
     * path="/api/categorias/{id}",
     * summary="Atualiza Categoria",
     * description="Atualiza uma Categoria, de acordo com o ID",
     * operationId="updatecategoria",
     * tags={"categorias"},
     * security={ {"bearer_token": {} }},
     * @OA\Parameter(
     *          description="ID da categoria",
     *          in="path",
     *          name="id",
     *          required=true,
     *          example="1",
     *      ),
     * @OA\Response(
     *    response=200,
     *    description="Sucesso",
     *    @OA\JsonContent(
     *       @OA\Property(property="mensagem", type="string", example="Ator atualizado")
     *        )
     *     ),
     * @OA\RequestBody(
     *    required=true,
     *    description="Nome da Categoria",
     *    @OA\JsonContent(
     *       required={"nome"},
     *       @OA\Property(property="nome", type="string", format="string", example="bruno"),
     * ),
     * ),
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
     *      path="/api/categorias/{id}",
     *      operationId="destroyCategoria",
     *      tags={"categorias"},
     *      summary="Deleta categoria",
     *      description="Deleta Categoria pelo ID da url",
     *      security={ {"bearer_token": {} }},
     *      @OA\Parameter(
     *          description="ID da Categoria",
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
     *      path="/api/categorias/{id}/filmes",
     *      operationId="filmesDaCategoria",
     *      tags={"categorias"},
     *      summary="Categoria dos Filmes",
     *      description="Retorna todos os filmes que essa categoria tem",
     *      security={ {"bearer_token": {} }},
     *      @OA\Parameter(
     *          description="ID da categoria",
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
    public function filmesDaCategoria(int $id)
    {
        $categoria = Categoria::find($id);
        return response()->json($categoria->filmes, 200);
    }
}
