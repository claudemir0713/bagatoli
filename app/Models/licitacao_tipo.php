<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class licitacao_tipo extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable= [
        'id', 'descricao', 'ativo','controla_preco_minimo'
    ];
    protected $primaryKey = 'id';
    protected $table = 'licitacao_tipo';
    // public $timestamps = false;
}
