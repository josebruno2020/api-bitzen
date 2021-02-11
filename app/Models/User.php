<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @OA\Schema(
 * required={"nome","senha","email"},
 * @OA\Property(property="id", type="integer", example="1"),
 * @OA\Property(property="nome", type="string", format="string", description="Nome do Usuário"),
 * @OA\Property(property="email", type="string", readOnly="true", format="email", description="User unique email address", example="user@gmail.com"),
 * @OA\Property(property="senha", type="string", format="password", description="Senha do Usuário"),
 * @OA\Property(property="email_verified_at", type="string", readOnly="true", format="date-time", description="Datetime marker of verification status", example="2019-02-25 12:59:20"),
 * @OA\Property(property="created_at", type="string", format="date-time", description="Criação inicial timestamp", readOnly="true"),
 * @OA\Property(property="updated_at", type="string", format="date-time", description="Última mudança timestamp", readOnly="true"),
 * )
 * Class User
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome',
        'email',
        'senha',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class);
    }
}
