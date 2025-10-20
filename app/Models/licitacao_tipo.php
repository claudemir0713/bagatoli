<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class licitacao_tipo extends Model
{
    use HasFactory;
    protected $fillable= [
        'id', 'descricao', 'ativo','controla_preco_minimo'
    ];
    protected $primaryKey = 'id';
    protected $table = 'licitacao_tipo';
    // public $timestamps = false;
}
