<?php

namespace App\Repositories;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Marca;
use DB;

class ProductoRepository
{
    public function create(array $dataProductos)
    {
        DB::beginTransaction();
        try {
            $data['nombre']=$dataProductos['nombre'];
            $data['imagen']=$dataProductos['imagen'];
            $data['unidad']=$dataProductos['unidad'];
            $data['cant_max']=$dataProductos['cant_max'];
            $data['cant_min']=$dataProductos['cant_min'];
            $data['precio']=$dataProductos['precio'];
            $data['cantidad']=$dataProductos['cantidad'];
            $data['codigo']=$dataProductos['codigo'];
            $data['marca_id']=$dataProductos['marca_id'];
            $data['categoria_id']=$dataProductos['categoria_id'];
            $producto = Producto::create($data);
            DB::commit();
            return $producto->id;
        } catch (Exception $e) {
            DB::rollback();
            return -1;
        } catch (QueryException $queryException) {
            DB::rollback();
            return -1;
        }
    }

    public function list()
    {
        $data = Producto::where('deleted_at', '=', null)->get();
        $producto = [];
        foreach ($data as $key => $value) {
            $producto[$key] = [
            'id'=>$value['id'],
            'nombre'=>$value['nombre'],
            'imagen'=>$value['imagen'],
            'unidad'=>$value['unidad'],
            'cant_max'=>$value['cant_max'],
            'cant_min'=>$value['cant_min'],
            'precio'=>$value['precio'],
            'cantidad'=>$value['cantidad'],
            'codigo'=>$value['codigo'],
            'categoria_id'=>$value->categoria->nombre,
            'marca_id'=>$value->marca->nombre,
        ];
        }
        return response()->json($producto);
    }

    public function update($id, $nombre, $imagen, $unidad, $cant_max, $cant_min, $precio, $cantidad, $codigo, $marca_id, $categoria_id)
    {
        $producto = $this->find($id)->first();
        $producto->nombre = $nombre;
        $producto->imagen = $imagen;
        $producto->unidad = $unidad;
        $producto->cant_max = $cant_max;
        $producto->cant_min = $cant_min;
        $producto->precio = $precio;
        $producto->cantidad = $cantidad;
        $producto->codigo = $codigo;
        $producto->marca_id = $marca_id;
        $producto->categoria_id = $categoria_id;
        return $producto->save();
    }

    public function delete($id)
    {
        $producto = $this->find($id)->first();
        return $producto->delete();
    }

    public function find($id)
    {
        return Producto::where('id', '=', $id)->first();
    }

    public function search($busqueda)
    {
        return Producto::where('nombre', 'like', '%'.$busqueda.'%')->
        orWhere('codigo', 'like', '%'.$busqueda.'%')->
        orWhere('marca_id', 'like', '%'.$busqueda.'%')->get();
    }
}
