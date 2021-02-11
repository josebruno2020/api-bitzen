<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * required={"nome"},
 * @OA\Property(property="id", type="integer", example="1"),
 * @OA\Property(property="nome", type="string", format="string", description="Nome do Filme", example="Vingadores"),
 * @OA\Property(property="created_at", type="string", format="date-time", description="Criação inicial timestamp", readOnly="true"),
 * @OA\Property(property="updated_at", type="string", format="date-time", description="Última mudança timestamp", readOnly="true"),
 * )
 * Class Filme
 *
 * @package App\Models
 */
class Filme extends Model
{
    use HasFactory;
    protected $fillable = ['nome'];
    protected $appends = ['links'];

    public function atores()
    {
        return $this->belongsToMany(
            Ator::class,
            'filmes_atores',
            'filme_id',
            'ator_id'
        );
    }

    public function categorias()
    {
        return $this->belongsToMany(
            Categoria::class,
            'filmes_categorias',
            'filme_id',
            'categoria_id'
        );
    }

    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class);
    }

    

    public function getLinksAttribute()
    {
        return [
            "self" => "/api/filmes/$this->id",
            "avaliar" => "/api/filmes/avaliar/$this->id",
            "atores" => "/api/filmes/$this->id/atores",
            "categorias" => "/api/filmes/$this->id/categorias"
        ];
    }
}
