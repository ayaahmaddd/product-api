<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $key = 'aya'; 
        $authHeader = $request->getHeaderLine('Authorization');

        if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $response = service('response');
            return $response->setStatusCode(401)->setJSON(['message' => 'Token Required']);
        }

        $token = $matches[1];

        try {
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
           
        } catch (\Exception $e) {
            $response = service('response');
            return $response->setStatusCode(401)->setJSON(['message' => 'Invalid Token']);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}
