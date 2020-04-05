<?php


namespace App\Domains\FibonacciEstimator;


use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class FibonacciEstimator
{
    const GOLDEN_RATIO = 1.6180339887498948482045868343656381177203091798057628621354486227052604628189024497072072041893911374;

    public function slice($from, $to): array
    {
        return ($from >= $to) ?
            $this->backwardSlice($from, $to) : $this->forwardSlice($from, $to);
    }

    private function forwardSlice(int $from, int $to): array
    {
        $slice = [];
        for ($i = $from; $i <= $to; $i++) {
            $slice[$i] = $this->getTerm($i);
        }
        return $slice;
    }

    private function backwardSlice(int $from, int $to): array
    {
        $slice = [];
        for ($i = $from; $i >= $to; $i--) {
            $slice[$i] = $this->getTerm($i);
        }
        return $slice;
    }

    private function getTerm($i): int
    {
        if (Cache::has($i)) {
            return Cache::get($i);
        }

        $term = $this->getFibonacciWithGoldenRatio($i);

        if (!$this->isFibonacci($term)) {
            $term = $this->getFibonacciRecursively($i);
            if (!$this->isFibonacci($term)) {
                throw new FibonacciEstimatorException("Can't calculate Fibonacci from term $i");
            }
        }

        if (is_float($term)) {
            throw new FibonacciEstimatorException("Term # $term is to big to estimate");
        }

        Cache::put($i, $term, Carbon::now()->addCentury());

        return $term;
    }

    private function getFibonacciRecursiveForward($n, $c = 2, $n2 = 0, $n1 = 1)
    {
        if ($n > 0) {
            return $c < $n ? $this->getFibonacciRecursiveForward($n, $c + 1, $n1, $n1 + $n2) : $n1 + $n2;
        }
    }

    private function getFibonacciWithGoldenRatio($i)
    {
        return (int)round((pow(self::GOLDEN_RATIO, $i) - pow(1 - self::GOLDEN_RATIO, $i)) / sqrt(5));
    }

    private function isFibonacci($n)
    {
        return $this->isPerfectSquare(5 * $n * $n + 4) ||
            $this->isPerfectSquare(5 * $n * $n - 4);
    }

    private function isPerfectSquare($x)
    {
        $s = (int)(sqrt($x));
        return ($s * $s == $x);
    }

    private function getFibonacciRecursively($i)
    {
        //TODO Cache could be used to improve performance (but this solution is fast enough by now)
        if ($i >= 0) {
            $term = $this->getFibonacciRecursiveForward($i);
        } else {
            $term = $this->getFibonacciRecursiveBackwards($i);
        }
        return $term;
    }

    private function getFibonacciRecursiveBackwards($n, $c = -2, $n2 = -1, $n1 = 1)
    {
        return $c > $n ? $this->getFibonacciRecursiveBackwards($n, $c - 1, $n1, $n1 + $n2) : $n1 + $n2;
    }
}
