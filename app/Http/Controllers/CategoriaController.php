<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CategoriaRepository;
use Validator;

class CategoriaController extends Controller
{
    protected $categoria_repository;

    public function __construct(CategoriaRepository $categoria)
    {
        $this->categoria_repository = $categoria;
    }

    public function create(Request $request)
    {
        $nombre = $request->input('nombre');
        $rules = [
            'nombre' => 'required|unique:categorias'
        ];
        $messages = [];
        $val = Validator::make($request->all(), $rules, $messages);
        if ($val->fails()) {
            return response()->json(
                array(
                'status' => 'error',
                'error' => $val->messages()
            )
            );
        } else {
            return response()->json($this->categoria_repository->create($nombre));
        }
    }

    public function update(Request $request, $id)
    {
        $nombre = $request->input('nombre');
        $rules = [
            'nombre' => 'required|unique:categorias'
        ];
        $messages = [];
        $val = Validator::make($request->all(), $rules, $messages);
        if ($val->fails()) {
            return response()->json(array(
                'status' => 'error',
                'error' => $val->messages()
            ));
        } else {
            return response()->json($this->categoria_repository->update($id, $nombre));
        }
    }

    public function list()
    {
        return response()->json($this->categoria_repository->list());
    }

    public function delete($id)
    {
        return response()->json($this->categoria_repository->delete($id));
    }

    public function find($id)
    {
        return response()->json($this->categoria_repository->find($id));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        return response()->json($this->categoria_repository->search($search));
    }
}
