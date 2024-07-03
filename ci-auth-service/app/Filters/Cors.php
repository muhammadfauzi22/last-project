<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Cors implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // $origin = $request->getHeader('Origin') ? $request->getHeader('Origin')->getValue() : '*';

        // Set CORS headers
        header("Access-Control-Allow-Origin: http://localhost:8082");
        header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

        // Handle preflight request
        if ($request->getMethod() === "OPTIONS") {
            header("Access-Control-Allow-Credentials: true");
            header("Access-Control-Max-Age: 3600");
            http_response_code(200);
            exit();
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
