<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 * required={"nome"},
 * @OA\Property(property="id", type="integer", example="1"),
 * @OA\Property(property="nome", type="string", format="string", description="Nome da Categoria", example="Ação"),
 * @OA\Property(property="created_at", type="string", format="date-time", description="Criação inicial timestamp", readOnly="true"),
 * @OA\Property(property="updated_at", type="string", format="date-time", description="Última mudança timestamp", readOnly="true"),
 * )
 * Class Categoria
 *
 * @package App\Models
 */
class Categoria extends Model
{
    use HasFactory;
    protected $fillable = ['nome'];
    protected $appends = ['links'];

    public function filmes()
    {
        return $this->belongsToMany(
            Filme::class,
            'filmes_categorias',
            'categoria_id',
            'filme_id'
        );
    }

    public function getLinksAttribute()
    {
        return [
            'self' => "/api/categorias/$this->id",
            'filmes' => "/api/categorias/$this->id/filmes"
        ];
    }
}
