<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public function jsonSuccess($data = [], $status = 200)
    {
        if (isset($data['message'])) {
            session()->flash('message', $data['message']);
        }

        return response()->json($data, $status);
    }

    public function jsonError($data = [], $status = 500)
    {
        if (isset($data['message'])) {
            session()->flash('error', $data['message']);
        }

        return response()->json($data, $status);
    }
}
