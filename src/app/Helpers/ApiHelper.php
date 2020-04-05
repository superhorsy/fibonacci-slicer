<?php


namespace App\Helpers;


use App\Domains\FileProcessor\FileProcessor;
use App\Domains\ImageConverter\ImageConverter;

class ApiHelper
{
    public static function error($message, $code)
    {
        return response([
            'success' => false,
            'code' => $code,
            'message' => $message
        ]);
    }

    public static function success($payload)
    {
        return response([
            'success' => true,
            'payload' => $payload,
        ]);
    }
}
