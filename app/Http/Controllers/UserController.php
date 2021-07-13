<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Validator\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        //RECOGER LOS DATOS DEL USUARIO POR POST
        $json = $request->input('json', null);
        $params = json_decode($json); //SACA UNOBJETO
        $params_array = json_decode($json, true); //SACA UN ARRAY

        if (!empty($params) && !empty($params_array)) {

        //LIMPIAR LOS DATOS
            $params_array = array_map('trim', $params_array);

            //VALIDAR LOS DATOS
            $validate = \Validator::make($params_array, [
            'name'      => 'required|alpha',
            'surname'   => 'required|alpha',
            'username'  => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required'
        ]);

            if ($validate->fails()) {
                //LA VALIDACION HA FALLADO
                $data = array(
                'code'      => 404,
                'status'    => 'ERROR',
                'message'   => 'El usuario no se ha creado',
                'errors'    => $validate->errors()
            );
            } else {
                //VALIDACION PASADA CORRECTAMENTE

                //CIFRAR CONTRASEÑA
                $pwd = hash('sha256', $params->password);

                //CREAR AL USUARIO
                $user = new User();
                $user->name = $params_array['name'];
                $user->surname = $params_array['surname'];
                $user->username = $params_array['username'];
                $user->email = $params_array['email'];
                $user->password = $pwd;

                //GUARDAR EL USUARIO
                $user->save();

                $data = array(
                'code'      => 200,
                'status'    => 'SUCCESS',
                'message'   => 'El usuario se ha creado correctamente',
                'user'      => $user
            );
                return response()->json($data, $data['code']);
            }
        } else {
            $data = array(
            'code'      => 404,
            'status'    => 'ERROR',
            'message'   => 'Los datos enviados no son correctos'
        );
        }

        return response()->json($data, $data['code']);
    }

    public function login(Request $request)
    {
        $jwtAuth = new \JwtAuth();

        //RECIBIR DATOS POR POST
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);

        //VALIDAR DATOS
        $validate = \Validator::make($params_array, [
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        if ($validate->fails()) {
            //LA VALIDACION HA FALLADO
            $signup = array(
                'code'      => 404,
                'status'    => 'ERROR',
                'message'   => 'El usuario no se ha podido loguear',
                'errors'    => $validate->errors()
            );
        } else {
            //CIFRAR CONTRASEÑA
            $pwd = hash('sha256', $params->password);

            //DEVOLVER TOKEN O DATOS
            $signup = $jwtAuth->signup($params->email, $pwd);

            if (!empty($params->gettoken)) {
                $signup = $jwtAuth->signup($params->email, $pwd, true);
            }
        }
        return response()->json($signup, 200);
    }

    public function update(Request $request)
    {
        //COMRPOBAR SI EL USUARIO ESTÁ LOGUEADO
        $token = $request->header('Authorization');
        $jwtAuth = new \JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);

        //RECOGER LOS DATOS POR POST
        $json = $request->input('json', null);
        $params_array = \json_decode($json, true);

        if ($checkToken && !empty($params_array)) {

            //SACAR USUARIO IDENTIFICADO
            $user = $jwtAuth->checkToken($token, true);

            //VALIDAR LOS DATOS
            $validate = \Validator::make($params_array, [
                'name'      => 'required|alpha',
                'surname'   => 'required|alpha',
                'username'  => 'required',
                'email'     => 'required|email|unique:users,'. $user->sub
            ]);

            //QUITAR LOS CAMPOS QUE NO SE QUIERAN ACTUALIZAR
            unset($params_array['id']);
            unset($params_array['password']);
            unset($params_array['created_at']);
            unset($params_array['remember_token']);

            //ACTUALIZAR AL USUARIO EN LA BASE DE DATOS
            $user_update = User::where('id', $user->sub)->update($params_array);

            //DEVOLVER UN ARRAY CON EL RESULTADO
            $data = array(
                'code' => 200,
                'status' => 'SUCCESS',
                'user' => $user,
                'changes' => $params_array
            );
        } else {
            $data = array(
                'code' => 400,
                'status' => 'ERROR',
                'message' =>  'El usuario no esta identificado'
            );
        }
        return response()->json($data, $data['code']);
    }

    public function upload(Request $request)
    {

        //RECOGER LA PETICIÓN
        $image = $request->file('file0');

        //VALIDACION DE LA IMAGEN
        $validate = \Validator::make($request->all(), [
            'file0' => 'required|image|mimes:jpg,jpeg,png,gif'
        ]);

        //GUARDAR LA IMAGEN
        if (!$image || $validate->fails()) {
            $data = array(
                'code' => 400,
                'status' => 'ERROR',
                'message' =>  'Error de al subir imagen'
            );
        } else {
            $image_name = time().$image->getClientOriginalName();
            \Storage::disk('users')->put($image_name, \File::get($image));

            $data = array(
                'code' => 200,
                'status' => 'SUCCESS',
                'image' => $image_name
            );
        }
        return response()->json($data, $data['code']);
    }

    public function getImage($filename)
    {
        $isset = \Storage::disk('users')->exists($filename);

        if ($isset) {
            $file = \Storage::disk('users')->get($filename);
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

    public function detail($id)
    {
        $user = User::find($id);

        if (is_object($user)) {
            $data = array(
                'code' => 200,
                'status' => 'SUCCESS',
                'user' => $user
            );
        } else {
            $data = array(
                'code' => 404,
                'status' => 'ERROR',
                'message' => 'El usuario no existe'
            );
        }
        return response()->json($data, $data['code']);
    }
}
