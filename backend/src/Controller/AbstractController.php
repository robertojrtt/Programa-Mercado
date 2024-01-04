<?php

namespace App\Controller;

abstract class AbstractController
{
    public function unprocessableEntity()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid fields'
        ]);
        return $response;
    }

    public function notFound()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }

    public function error($message)
    {
        $response['status_code_header'] = 'HTTP/1.1 500 Internal Server Error';
        $response['body'] = json_encode([
            'error' => $message
        ]);
        return $response;
    }

    public function getParams()
    {
        return json_decode(file_get_contents('php://input'), TRUE);
    }
}
