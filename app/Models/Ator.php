<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 * required={"nome"},
 * @OA\Property(property="id", type="integer", example="1"),
 * @OA\Property(property="nome", type="string", format="string", description="Nome do Ator", example="John"),
 * @OA\Property(property="nacionalidade", type="string", format="string", description="Nacionalidade do Ator"),
 * @OA\Property(property="obs", type="string", format="string", description="Abservações a respeito do Ator"),
 * @OA\Property(property="created_at", type="string", format="date-time", description="Criação inicial timestamp", readOnly="true"),
 * @OA\Property(property="updated_at", type="string", format="date-time", description="Última mudança timestamp", readOnly="true"),
 * )
 * Class Ator
 *
 * @package App\Models
 */
class Ator extends Model
{
    use HasFactory;
    protected $table = 'atores';
    protected $fillable = ['nome', 'nacionalidade', 'obs'];
    protected $appends = ['links'];

    public function filmes()
    {
        return $this->belongsToMany(
            Filme::class,
            'filmes_atores',
            'ator_id',
            'filme_id'
        );
    }

    public function getLinksAttribute()
    {
        return [
            'self' => "/api/atores/$this->id",
            'filmes' => "/api/atores/$this->id/filmes"
        ];
    }
}
