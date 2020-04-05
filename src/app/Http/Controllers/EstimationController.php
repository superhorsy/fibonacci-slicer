<?php

namespace App\Http\Controllers;

use App\Domains\FibonacciEstimator\FibonacciEstimator;
use Illuminate\Http\Request;

class EstimationController extends Controller
{

    /**
     * @var FibonacciEstimator
     */
    private $fibonacci;

    public function __construct()
    {
        $this->fibonacci = new FibonacciEstimator();
    }

    public function getSlice(Request $request)
    {
        $this->validateSliceRequest($request);

        return $this->success($this->fibonacci->slice($request->from, $request->to));
    }

    private function validateSliceRequest(Request $request)
    {
        $this->validate($request, [
            'from' => 'required|integer',
            'to' => 'required|integer'
        ]);
    }
}
