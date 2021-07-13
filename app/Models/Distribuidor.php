<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Distribuidor extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'distribuidores';
    protected $fillable = [
        'nombre',
        'telefono',
        'correo',
        'numero_de_cuenta'
    ];
}
