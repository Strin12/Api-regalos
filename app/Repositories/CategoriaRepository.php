<?php

namespace App\Repositories;

use App\Models\Categoria;

class CategoriaRepository
{
    public function create($nombre)
    {
        $nueva_categoria['nombre'] = $nombre;
        return Categoria::create($nueva_categoria);
    }

    public function list()
    {
        return Categoria::all();
    }

    public function update($id, $nombre)
    {
        $categoria = $this->find($id);
        $categoria->nombre = $nombre;
        return $categoria->save();
    }

    public function delete($id)
    {
        $categoria = $this->find($id);
        return $categoria->delete();
    }

    public function find($id)
    {
        return Categoria::where('id', '=', $id)->first();
    }

    public function search($busqueda)
    {
        return Categoria::where('nombre', 'like', '%' . $busqueda . '%')->get();
    }
}
