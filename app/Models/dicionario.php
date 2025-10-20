<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dicionario extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable= [
        'id'
        ,'descricao'
        ,'tag'
    ];
    protected $primaryKey = 'id';
    protected $table = 'dicionario';
}
