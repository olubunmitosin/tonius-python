<?php
namespace tonius\python\tests;

use PHPUnit\Framework\TestCase;
use tonius\python\Facades\Python;

class PythonTest extends \Orchestra\Testbench\TestCase
{
    protected $fileName;

    protected $options;

    public function setUp()
    {
        parent::setUp();
        $this->fileName = null;
        $this->options = ['test' => true];
    }

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
