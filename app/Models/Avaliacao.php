<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 * required={"avaliacao", "user_id", "filme_id"},
 * @OA\Property(property="id", type="integer", example="1"),
 * @OA\Property(property="avaliacao", type="integer", format="int", description="Avaliação do filme"),
 * @OA\Property(property="user_id", type="integer", format="int", description="ID do usuário que fez a avaliação"),
 * @OA\Property(property="filme_id", type="integer", format="int", description="ID do filme que foi avaliado"),
 * @OA\Property(property="created_at", type="string", format="date-time", description="Criação inicial timestamp", readOnly="true"),
 * @OA\Property(property="updated_at", type="string", format="date-time", description="Última mudança timestamp", readOnly="true"),
 * )
 * Class Avaliacao
 *
 * @package App\Models
 */
class Avaliacao extends Model
{
    use HasFactory;
    protected $table = 'avaliacoes';
    protected $fillable = ['avaliacao', 'user_id', 'filme_id'];
}
