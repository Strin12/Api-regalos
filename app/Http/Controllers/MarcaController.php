<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\MarcaRepository;
use Validator;

class MarcaController extends Controller
{
    protected $marca_repository;

    public function __construct(MarcaRepository $marca)
    {
        $this->marca_repository = $marca;
    }

    public function create(Request $request)
    {
        $nombre = $request->input('nombre');
        $rules = [
            'nombre' => 'required|unique:marcas'
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
            return response()->json($this->marca_repository->create($nombre));
        }
    }

    public function update(Request $request, $id)
    {
        $nombre = $request->input('nombre');
        $rules = [
            'nombre' => 'required|unique:marcas'
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
            return response()->json($this->marca_repository->update($id, $nombre));
        }
    }

    public function list()
    {
        return response()->json($this->marca_repository->list());
    }

    public function delete($id)
    {
        return response()->json($this->marca_repository->delete($id));
    }

    public function find($id)
    {
        return response()->json($this->marca_repository->find($id));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        return response()->json($this->marca_repository->search($search));
    }
}
