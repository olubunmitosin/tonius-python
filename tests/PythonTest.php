<?php

namespace tonius\python\tests;

use tonius\python\Facades\Python;

class PythonTest extends \Orchestra\Testbench\TestCase
{
    protected $fileName = null;

    protected $options = ['test' => true];

    protected function getPackageProviders($app)
    {
        return ['tonius\\python\\pythonServiceProvider'];
    }

    public function testOutput()
    {
        $response = Python::run($this->fileName, $this->options);
        $this->assertArrayHasKey('result', $response);
        $this->assertIsBool($response['success']);
    }
}
