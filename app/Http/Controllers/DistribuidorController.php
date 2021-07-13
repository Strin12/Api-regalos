<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\DistribuidorRepository;
use Validator;

class DistribuidorController extends Controller
{
    protected $distribuidor_repository;

    public function __construct(DistribuidorRepository $distribuidor)
    {
        $this->distribuidor_repository = $distribuidor;
    }

    public function create(Request $request)
    {
        $nombre = $request->input('nombre');
        $telefono = $request->input('telefono');
        $correo = $request->input('correo');
        $numero_de_cuenta = $request->input('numero_de_cuenta');
        $rules = [
            'nombre' => 'required|unique:distribuidores',
            'telefono' => 'required',
            'correo' => 'required|email|unique:distribuidores',
            'numero_de_cuenta' => 'required'
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
            return response()->json($this->distribuidor_repository->create($nombre, $telefono, $correo, $numero_de_cuenta));
        }
    }

    public function update(Request $request, $id)
    {
        $nombre = $request->input('nombre');
        $telefono = $request->input('telefono');
        $correo = $request->input('correo');
        $numero_de_cuenta = $request->input('numero_de_cuenta');
        $rules = [
            'nombre' => 'required|unique:distribuidores',
            'telefono' => 'required',
            'correo' => 'required|email|unique:distribuidores',
            'numero_de_cuenta' => 'required'
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
            return response()->json($this->distribuidor_repository->update($id, $nombre, $telefono, $correo, $numero_de_cuenta));
        }
    }

    public function list()
    {
        return response()->json($this->distribuidor_repository->list());
    }

    public function delete($id)
    {
        return response()->json($this->distribuidor_repository->delete($id));
    }

    public function find($id)
    {
        return response()->json($this->distribuidor_repository->find($id));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        return response()->json($this->distribuidor_repository->search($search));
    }
}
