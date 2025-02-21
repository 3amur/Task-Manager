<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    // return success
    public function sendResponse($result, $message){
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $result
        ];
        return response()->json($response, 200);
    }
    // return errors
    public function sendError($error, $errorMessages, $code = 404){
        $response = [
            'success' => false,
            'message' => $error,
        ];
        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }
}
