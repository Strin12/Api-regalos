<?php

namespace App\Repositories;

use App\Models\Distribuidor;

class DistribuidorRepository
{
    public function create($nombre, $telefono, $correo, $numero_de_cuenta)
    {
        $nuevo_distrbuidor['nombre']=$nombre;
        $nuevo_distrbuidor['telefono']=$telefono;
        $nuevo_distrbuidor['correo']=$correo;
        $nuevo_distrbuidor['numero_de_cuenta']=$numero_de_cuenta;
        return Distribuidor::create($nuevo_distrbuidor);
    }

    public function list()
    {
        return Distribuidor::all();
    }

    public function update($id, $nombre, $telefono, $correo, $numero_de_cuenta)
    {
        $distribuidor = $this->find($id);
        $distribuidor->nombre = $nombre;
        $distribuidor->telefono = $telefono;
        $distribuidor->correo = $correo;
        $distribuidor->numero_de_cuenta = $numero_de_cuenta;
        return $distribuidor->save();
    }

    public function delete($id)
    {
        $distribuidor = $this->find($id);
        return $distribuidor->delete();
    }

    public function search($busqueda)
    {
        return Distribuidor::where('nombre', 'like', '%'.$busqueda.'%')->get();
    }

    public function find($id)
    {
        return Distribuidor::where('id', '=', $id)->first();
    }
}
