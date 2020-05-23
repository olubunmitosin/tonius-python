<?php
namespace tonius\python\Tests;

use PHPUnit\Framework\TestCase;
use tonius\python\Facades\Python;

class PythonTest extends TestCase
{
    protected $fileName;

    protected $options;

    public function setUp()
    {
        parent::setUp();
        $this->fileName = null;
        $this->options = ['test' => true];
    }


    public function testOutput()
    {
        $response = Python::run($this->fileName, $this->options);
        $this->assertArrayHasKey('result', $response);
        $this->assertIsBool($response['success']);
    }
}
