<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Atributos que podem ser atribuidos em massa (mass assignment).
     *
     * @var string[]
     */
    protected $fillable = [
        'nome',
        'email',
        'senha',
    ];

    /**
     * Atributos que são ocultados quando é feita a serialização da instância do modelo.
     *
     * @var string[]
     */
    protected $hidden = [
        'senha',
    ];

    /**
     * Assessor utilizado para que o Fortify funcione corretamente.
     *
     * @return string
     */
    public function getPasswordAttribute()
    {
        return $this->senha;
    }
}
