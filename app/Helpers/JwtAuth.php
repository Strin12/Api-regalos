<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class JwtAuth
{
    public $key;

    public function __construct()
    {
        $this->key = 'esto_es_una_clave_super_secreta-998877';
    }

    public function signup($email, $password, $gettoken = null)
    {
        //BUSCAR SI EXISTE EL USUARIO CON SUS CREDENCIALES
        $user = User::where([
            'email' => $email,
            'password' => $password
        ])->first();

        //COMPROBAR SI SON CORRECTAS
        $signup = false;
        if(is_object($user)){
            $signup = true;
        }

        //GENERAR EL TOKEN CON LOS DATOS DEL USUARIO
        if($signup){
            $token = array(
                'sub'       => $user->id,
                'email'     => $user->email,
                'name'      => $user->name,
                'surname'   => $user->surname,
                'image'   => $user->image,
                'username'  => $user->username,
                'iat'       => time(),
                'exp'       => time() + (7 * 24 * 60 * 60)
            );

            $jwt = JWT::encode($token, $this->key, 'HS256');
            $decoded = JWT::decode($jwt, $this->key, ['HS256']);
            //DEVOLVER LOS DATOS DECODIFICADOS O EL TOKEN EN FUNCIÓN DE UN PARÁMETRO
            if(is_null($gettoken)){
                $data = $jwt;
            }else{
                $data = $decoded;
            }

        }else{
            $data = array(
                'status' => 'Error',
                'message' => 'Login incorrecto'
            );
        }
        return $data;
    }

    public function checkToken($jwt, $getIdentity = false)
    {
        $auth = false;

        try{
            $jwt = str_replace('"', '', $jwt);
            $decoded = JWT::decode($jwt, $this->key, ['HS256']);
        }catch(\UnexpectedValueException $e){
            $auth = false;
        }catch(\DomainException $e){
            $auth = false;
        }

        if(!empty($decoded) && is_object($decoded) && isset($decoded->sub)){
            $auth = true;
        }else{
            $auth = false;
        }

        if($getIdentity){
            return $decoded;
        }

        return $auth;
    }
}
