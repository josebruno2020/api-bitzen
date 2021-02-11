<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TokenController extends Controller
{

    /**
     * @OA\Post(
     * path="/api/login",
     * summary="Login",
     * description="Login por email e senha. Será retornado o token de acesso para as outras rotas.",
     * operationId="login",
     * tags={"usuarios"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"email","senha"},
     *       @OA\Property(property="email", type="string", format="email", example="bruno@teste.com"),
     *       @OA\Property(property="senha", type="string", format="password", example="123"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Sucesso",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Login Efetuado")
     *        )
     *     )
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Não autorizado",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="E-mail ou senha inválidos")
     *        )
     *     )
     * )
     */

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'email|required',
            'senha' => 'required'
        ]);
        
        $usuario = User::where('email', $request->email)->first();

        if(is_null($usuario) || !Hash::check($request->senha, $usuario->senha)){
            return response()->json('Usuário ou senha inválidos', 401);
        }
        $token = JWT::encode([
            'id' => $usuario->id,
            'nome' => $usuario->nome,
            'email' => $request->email
        ], env('JWT_KEY'));

        return [
            'access_token' => $token
        ];
    }
}
