<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class licitacao_tipo_item extends Model
{
    use HasFactory;
    protected $fillable= [
        'id', 'tipo_id', 'descricao'
    ];
    protected $primaryKey = 'id';
    protected $table = 'licitacao_tipo_item';
    // public $timestamps = false;
}
