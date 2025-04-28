<?php

namespace App\Traits;

trait AllResponseApi
{
    protected function success($data,$message="success"){
       return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
            'code' => 200

        ]);
    }


    protected function error($message="error"){
       return response()->json([
            'status' => false,
            'message' => $message,
            'code' => 400
        ]);
    }
}
