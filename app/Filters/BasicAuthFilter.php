<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\Response;

class BasicAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $username = 'admin';
        $password = '1234';

        $header = $request->getHeaderLine('Authorization');

        if (strpos($header, 'Basic ') === 0) {
            $encodedCredentials = substr($header, 6);
            $decodedCredentials = base64_decode($encodedCredentials);
            [$inputUser, $inputPass] = explode(':', $decodedCredentials, 2);

            if ($inputUser === $username && $inputPass === $password) {
                return; // 
            }
        }

        // 
        $response = service('response');
        return $response
            ->setStatusCode(401)
            ->setHeader('WWW-Authenticate', 'Basic realm="My Realm"')
            ->setBody('Unauthorized');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No changes after response
    }
}


