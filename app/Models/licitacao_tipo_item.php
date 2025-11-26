<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class licitacao_tipo_item extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable= [
        'id', 'tipo_id', 'descricao'
    ];
    protected $primaryKey = 'id';
    protected $table = 'licitacao_tipo_item';
    // public $timestamps = false;
}
