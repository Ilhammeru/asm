<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, DispatchesJobs;

    public function success($message, $data = [])
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'success' => true,
        ], 200);
    }

    public function notify($data)
    {
        if ($data['status'] == 200) {
            return $this->success($data['message'], $data['data']);
        } else {
            return $this->error($data['message'], $data['data'] ?? []);
        }
    }

    public function error($message, $data = [])
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'success' => false,
        ], 500);
    }

    public function validationErrors($errors)
    {
        return response()->json([
            'errors' => $errors->errors(),
            'message' => 'Validation errors',
            'success' => false,
        ], 422);
    }

    public function buildValidationError($data)
    {
        return response()->json([
            'errors' => $data,
            'message' => 'Validation errors',
            'success' => false,
        ], 422);
    }

    public function messageError($err)
    {
        if (env('APP_ENV') == 'local' || env('APP_ENV') == 'staging') {
            return $err->getMessage() . ' - ' . $err->getLine() . ' - ' . $err->getFile();
        } else {
            return __('global.process_failed');
        }
    }
}
