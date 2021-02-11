<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/usuarios",
     *      operationId="indexUser",
     *      tags={"usuarios"},
     *      summary="Usuarios do sistema",
     *      description="Retorna os usuarios cadastrados",
     *      security={ {"bearer_token": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Sucesso",
     *          @OA\JsonContent(
     *          @OA\Property(property="usuarios", type="object", 
     *          ref="#/components/schemas/User"),
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
        $usuarios = User::paginate();
        return response()->json($usuarios, 200);
    }


    /**
     * @OA\Post(
     * path="/api/usuarios",
     * summary="Cria um usuário",
     * description="Método para criar um novo usuário",
     * operationId="store",
     * tags={"usuarios"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Nome, E-mail e senha do usuário",
     *    @OA\JsonContent(
     *       required={"nome","email", "senha"},
     *       @OA\Property(property="nome", type="string", format="string", example="bruno"),
     *       @OA\Property(property="email", type="email", format="string", example="user@email.com"),
     *   
     *       @OA\Property(property="senha", type="password", format="string", example="Password123"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Sucesso",
     *    @OA\JsonContent(
     *       @OA\Property(property="mensagem", type="string", example="Novo Usuário cadastrado")
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
    public function store(UsuarioRequest $request)
    {
        $usuario = new User();
        $usuario->nome = $request->nome;
        $usuario->email = $request->email;
        $usuario->senha = bcrypt($request->senha);
        $usuario->save();
        return response()
            ->json($usuario, 201);
    }

    /**
     * @OA\Get(
     *      path="/api/usuarios/{id}",
     *      operationId="showUser",
     *      tags={"usuarios"},
     *      summary="Mostra Usuário",
     *      description="Retorna Usuário pelo ID da url",
     *      security={ {"bearer_token": {} }},
     *      @OA\Parameter(
     *          description="ID do usuário",
     *          in="path",
     *          name="id",
     *          required=true,
     *          example="1",
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Sucesso",
     *          @OA\JsonContent(
     *          @OA\Property(property="user", type="object", 
     *          ref="#/components/schemas/User"),
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
        $usuario = User::find($id);
        if(is_null($usuario)){
            return response()
                ->json([
                    'erro' => 'Usuário não encontrado'
                ], 404);
        }
        return response()->json($usuario, 200);
    }

    /**
     * @OA\Put(
     * path="/api/usuarios/{id}",
     * summary="Atualiza Usuário",
     * description="Atualiza um Usuário, de acordo com o ID",
     * operationId="updateUser",
     * tags={"usuarios"},
     * security={ {"bearer_token": {} }},
     * @OA\Parameter(
     *          description="ID do usuário",
     *          in="path",
     *          name="id",
     *          required=true,
     *          example="1",
     *      ),
     * @OA\RequestBody(
     *    required=true,
     *    description="Nome, E-mail e senha do usuário",
     *    @OA\JsonContent(
     *       required={"nome","email", "senha"},
     *       @OA\Property(property="nome", type="string", format="string", example="bruno"),
     *       @OA\Property(property="email", type="email", format="string", example="user@email.com"),
     *   
     *       @OA\Property(property="senha", type="password", format="string", example="Password123"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Sucesso",
     *    @OA\JsonContent(
     *       @OA\Property(property="mensagem", type="string", example="Usuário atualizado")
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
    public function update(int $id, UsuarioRequest $request)
    {
        $usuario = User::find($id);
        if(is_null($usuario)){
            return response()
                ->json([
                    'erro' => 'Usuário não encontrado'
                ], 404);
        }

        $usuario->update([
            'nome' => $request->nome,
            'email' => $request->email,
            'senha' => bcrypt($request->senha)
        ]);
        return response()->json($usuario, 200);
    }


    /**
     * @OA\Delete(
     *      path="/api/usuarios/{id}",
     *      operationId="destroyUser",
     *      tags={"usuarios"},
     *      summary="Deleta Usuário",
     *      description="Deleta Usuário pelo ID da url",
     *      security={ {"bearer_token": {} }},
     *      @OA\Parameter(
     *          description="ID do usuário",
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
        $qt = User::destroy($id);
        if($qt == 0){
            return response()
                ->json([
                    'erro' => 'Usuário não encontrado'
                ], 404);
        }
        return response()->json('', 204);
    }
}
