<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected function successResponse($data, $message = null, $status = 200)
    {
        return response()->json([
            'success' => 1,
            'message' => $message ?: 'success.',
            'data' => $data
        ], $status);
    }
    protected function failedResponse($data, $message = null, $status = 400)
    {
        return response()->json([
            'success' => 0,
            'message' => $message ?: 'Failure.',
            'data' => $data
        ], $status);
    }
}
