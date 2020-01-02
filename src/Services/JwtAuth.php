<?php
namespace App\Services;

use Firebase\JWT\JWT;
use App\Entity\User;

class JwtAuth{
        
    public $manager;
    public $key;
    
    public function __construct($manager) {
        $this->manager = $manager;
        $this->key = 'Hola_que_tal_este_es_el_master_fullstack786512369874';
    }
    
    public function signup($email, $password, $gettoken = null){
        
        //Comprobar si el usuario existe
        $user = $this->manager->getRepository(User::class)->findOneBy([
            'email' => $email,
            'password' => $password
        ]);
        
        $signup = false;
        if(is_object($user)){
            $signup = true;
        }
        //Si existe generar el token de jwt
        if($signup){
            $token = [
                'sub' => $user->getId(),
                'name' => $user->getName(),
                'surname' => $user->getSurName(),
                'email' => $user->getEmail(),
                'iat' => time(),
                'exp' => time() + (7 * 24 * 60 * 60)
            ];
            $jwt = JWT::encode($token, $this->key, 'HS256');
            //Comprobar el flag gettoken, condición
            if(!empty($gettoken)){
                $data = $jwt;
            }else{
                $decoded = JWT::decode($jwt, $this->key, ['HS256']);
                $data = $decoded;
            }
        }else{
            $data = [
                'status' => 'error',
                'message' => 'Login incorrecto'
            ];
        }
        
        
        //Devolver los datos
        return $data;
    }
    
    public function checkToken($jwt, $identity = false){
        $auth = false;
        
        try{
        $decoded = JWT::decode($jwt, $this->key, ['HS256']);
        if($decoded && !empty($decoded) && is_object($decoded) && isset($decoded->sub)){
            $auth = true;
        }
        }catch(\UnexpectedValueException $e){
            $auth = false;
        }catch(\DomainException $e){
            $auth = false;
            
        }      
        if($identity != false){
            return $decoded;
        }else{
            return $auth;
        }
    }
}