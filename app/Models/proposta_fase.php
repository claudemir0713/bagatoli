<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class proposta_fase extends Model
{
    use HasFactory;
    protected $fillable= [
        'id', 'descricao', 'status'
    ];
    protected $primaryKey = 'id';
    protected $table = 'proposta_fase';
    // public $timestamps = false;
}
