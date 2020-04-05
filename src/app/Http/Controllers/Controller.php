<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected function error($message, $code)
    {
        return ApiHelper::error($message,$code);
    }

    protected function success($payload)
    {
        return ApiHelper::success($payload);
    }
}
