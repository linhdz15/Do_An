<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public function jsonSuccess($message, $data = [], $status = 200)
    {
        $data = array_merge(['message' => $message], $data);

        return response()->json($data, $status);
    }

    public function jsonServerError($data = [])
    {
        $data = array_merge(['message' => __('Server Error. Please try again later!')], $data);

        return response()->json($data, 500);
    }
}
