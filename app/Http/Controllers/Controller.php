<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="API Filmes",
     *      description="API desenvolvida para uma plataforma de filmes",
     *      @OA\Contact(
     *          email="josebrunocampanholi@gmail.com"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="Servidor de testes"
     * ),
     * @OA\Tag(
     *     name="filmes",
     *     description="End points para Filmes"
     * )
     * @OA\Tag(
     *     name="categorias",
     *     description="End points para Categorias"
     * )
     * @OA\Tag(
     *     name="atores",
     *     description="End points para Atores"
     * )
     * * @OA\Tag(
     *     name="usuarios",
     *     description="End points para Usuários"
     * )
     */
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    
}
