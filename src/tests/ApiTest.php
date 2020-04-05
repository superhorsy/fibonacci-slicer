<?php

class ApiTest extends TestCase{
    public function testSlice()
    {
        $this->json('POST', '/slice', ['from' => 0,'to' => 1])
            ->seeJson([
                'success' => true,
                'payload' => [
                    0 => 0,
                    1 => 1
                ],
            ]);
    }
}
