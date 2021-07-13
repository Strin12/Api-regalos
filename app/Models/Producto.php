<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'productos';
    protected $fillable = [
        'nombre',
        'imagen',
        'unidad',
        'cant_max',
        'cant_min',
        'precio',
        'cantidad',
        'codigo',
        'categoria_id',
        'marca_id'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id', 'id');
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca_id', 'id');
    }
}
