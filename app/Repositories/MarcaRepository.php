<?php

namespace App\Repositories;

use App\Models\Marca;

class MarcaRepository
{
    public function create($nombre)
    {
        $nueva_marca['nombre'] = $nombre;
        return Marca::create($nueva_marca);
    }

    public function list()
    {
        return Marca::all();
    }

    public function update($id, $nombre)
    {
        $marca = $this->find($id);
        $marca->nombre = $nombre;
        return $marca->save();
    }

    public function delete($id)
    {
        $marca = $this->find($id);
        return $marca->delete();
    }

    public function find($id)
    {
        return Marca::where('id', '=', $id)->first();
    }

    public function search($busqueda)
    {
        return Marca::where('nombre', 'like', '%'.$busqueda.'%')->get();
    }
}
