<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    protected function ok($data, string $message = '', int $status = 200) 
    {
        return $this->responseJson($data, $message, $status);
    }

    protected function created($data, string $message = '', int $status = 201) 
    {
        return $this->responseJson($data, $message, $status);
    }

    protected function error($message, int $status = 500, array $errors = []) 
    {
        return response()->json([
            'success'   => false,
            'code'      => $status,
            'message'   => $message,
            'errors'    => $errors
        ], $status);
    }

    private function responseJson($data, $message, $status) 
    {
        return response()->json(["message" => $message, "success" => true, "code"=> $status, "data" => $data], $status);
    }
}
