<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController extends ResourceController
{
    private $key = 'aya'; 
    public function login()
    {
        $userModel = new UserModel();
        $input = $this->request->getJSON(true);

        $user = $userModel->where('username', $input['username'])->first();

        if (!$user || !password_verify($input['password'], $user['password'])) {
            return $this->failUnauthorized('Invalid credentials.');
        }

        $payload = [
            'iss' => 'localhost',
            'aud' => 'localhost',
            'iat' => time(),
            'exp' => time() + 3600,
            'uid' => $user['id'],
        ];

        $token = JWT::encode($payload, $this->key, 'HS256');

        return $this->respond(['token' => $token]);
    }

    // اختياري: إنشاء مستخدم جديد
    public function register()
    {
        $userModel = new UserModel();
        $input = $this->request->getJSON(true);

        $userModel->save([
            'username' => $input['username'],
            'password' => password_hash($input['password'], PASSWORD_DEFAULT),
        ]);

        return $this->respondCreated(['message' => 'User registered successfully']);
    }
}
