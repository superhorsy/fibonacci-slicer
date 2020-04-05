<?php

use App\Domains\FibonacciEstimator\FibonacciEstimator;
use App\Domains\FibonacciEstimator\FibonacciEstimatorException as FibonacciEstimatorException;

class FibonacciEstimatorTest extends TestCase
{
    /**
     * @var FibonacciEstimator
     */
    private $estimator;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->estimator = new FibonacciEstimator();
    }

    public function testGetTerm()
    {
        $class = new ReflectionClass(FibonacciEstimator::class);
        $method = $class->getMethod('getTerm');
        $method->setAccessible(true);

        $fib_0 = $method->invoke($this->estimator, 0);
        $this->assertEquals(0, $fib_0);
        $fib_14 = $method->invoke($this->estimator, 14);
        $this->assertEquals(377, $fib_14);
        //Negative number test
        $fib_n5 = $method->invoke($this->estimator, -6);
        $this->assertEquals(-8, $fib_n5);
        $fib_50 = $method->invoke($this->estimator, 50);
        $this->assertEquals(12586269025, $fib_50);
        //Big Number Test
        $fib_74 = $method->invoke($this->estimator, 74);
        $this->assertEquals(1304969544928657, $fib_74);
        //Very big number
        $this->expectException(FibonacciEstimatorException::class);
        $fib_100 = $method->invoke($this->estimator, 100);
    }

    public function testIsFibonacci()
    {
        $class = new ReflectionClass(FibonacciEstimator::class);
        $method = $class->getMethod('isFibonacci');
        $method->setAccessible(true);

        $fib_50 = $method->invoke($this->estimator, 12586269025);
        $this->assertTrue($fib_50);

        $fib_b50 = $method->invoke($this->estimator, 555555555);
        $this->assertFalse($fib_b50);

        $fib_74 = $method->invoke($this->estimator, 1304969544928657);
        $this->assertTrue($fib_74);
    }

    public function testSlice()
    {
        $this->positive();
        $this->negative();
        $this->combined();
    }

    private function positive(): void
    {
        $slice_0_2 = $this->estimator->slice(0, 2);
        $this->assertEquals([0 => 0, 1 => 1, 2 => 1], $slice_0_2);
        $slice_3_5 = $this->estimator->slice(3, 5);
        $this->assertEquals([3 => 2, 4 => 3, 5 => 5], $slice_3_5);
    }

    private function negative(): void
    {
        $slice_1_2 = $this->estimator->slice(0, -2);
        $this->assertEquals([
            0 => 0,
            -1 => 1,
            -2 => -1
        ], $slice_1_2);
    }

    private function combined()
    {
        $slice_n1_2 = $this->estimator->slice(-1, 2);
        $this->assertEquals([
            -1 => 1,
            0 => 0,
            1 => 1,
            2 => 1
        ], $slice_n1_2);

        $slice_3_n1 = $this->estimator->slice(3, -1);
        $this->assertEquals([
            3 => 2,
            2 => 1,
            1 => 1,
            0 => 0,
            -1 => 1
        ], $slice_3_n1);
    }
}
