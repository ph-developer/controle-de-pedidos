<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    /**
     * Atributos que podem ser atribuidos em massa (mass assignment).
     *
     * @var string[]
     */
    protected $fillable = [
        'numero',
        'tipo',
        'dataChegada',
        'secretariaSolicitante',
        'projeto',
        'descricao',
        'dataEnvioFinanceiro',
        'dataRetornoFinanceiro',
        'situacaoAutorizacao',
        'observacoes',
    ];
}
