<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProductoRepository;
use Illuminate\Http\Response;
use Validator;

class ProductoController extends Controller
{
    protected $producto_repository;

    public function __construct(ProductoRepository $producto)
    {
        $this->producto_repository = $producto;
    }

    public function create(Request $request)
    {
        $data['nombre']=$request->input('nombre');
        $data['imagen']=$request->input('imagen');
        $data['unidad']=$request->input('unidad');
        $data['cant_max']=$request->input('cant_max');
        $data['cant_min']=$request->input('cant_min');
        $data['precio']=$request->input('precio');
        $data['cantidad']=$request->input('cantidad');
        $data['codigo']=$request->input('codigo');
        $data['marca_id']=$request->input('marca_id');
        $data['categoria_id']=$request->input('categoria_id');
        return response()->json($this->producto_repository->create($data));
    }

    public function update(Request $request, $id)
    {
        $nombre = $request->input('nombre');
        $imagen = $request->input('imagen');
        $unidad = $request->input('unidad');
        $cant_max = $request->input('cant_max');
        $cant_min = $request->input('cant_min');
        $precio = $request->input('precio');
        $cantidad = $request->input('cantidad');
        $codigo = $request->input('codigo');
        $marca_id = $request->input('marca_id');
        $categoria_id = $request->input('categoria_id');
        return response()->json($this->producto_repository->update($id, $nombre, $imagen, $unidad, $cant_max, $cant_min, $precio, $cantidad, $codigo, $marca_id, $categoria_id));
    }

    public function list()
    {
        return $this->producto_repository->list();
    }

    public function delete($id)
    {
        return response()->json($this->producto_repository->delete($id));
    }

    public function find($id)
    {
        return response()->json($this->producto_repository->find($id));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        return response()->json($this->producto_repository->search($search));
    }

    public function upload(Request $request)
    {
        $image = $request->file('file0');
        $validate = \Validator::make($request->all(), [
            'file0' => 'required|image|mimes:jpg,jpeg,png,gif'
        ]);
        if (!$image || $validate->fails()) {
            $data = array(
                'code' => 400,
                'status' => 'error',
                'message' =>  'Error de al subir imagen'
            );
        } else {
            $image_name = time().$image->getClientOriginalName();
            \Storage::disk('productos')->put($image_name, \File::get($image));
            $data = array(
                'code' => 200,
                'status' => 'success',
                'image' => $image_name
            );
        }
        return response()->json($data, $data['code']);
    }

    public function getImage($filename)
    {
        $isset = \Storage::disk('productos')->exists($filename);

        if ($isset) {
            $file = \Storage::disk('productos')->get($filename);
            return new Response($file, 200);
        } else {
            $data = array(
                'code' => 404,
                'status' => 'ERROR',
                'message' =>  'La imagen no existe'
            );
            return response()->json($data, $data['code']);
        }
    }
}
