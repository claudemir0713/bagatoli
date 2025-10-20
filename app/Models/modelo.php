<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modelo extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable=[
        'id'
        ,'descricao'
        ,'tamanho'
        ,'modelo'
        ,'botaoCor'
        ,'botaoImagem'
        ,'tipo'

    ];
    protected $primaryKey = 'id';
    protected $table = 'modelo';
}
