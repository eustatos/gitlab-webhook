<?php
require_once(__DIR__ . '/../vendor/autoload.php');

class EventTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
       $this->event = new Eustatos\gitlab\webhook\Event(
          'ls -la',
          'Gfhjkm123',
           $_SERVER
        );
    }
    public function tearDown()
    {
        $this->event = NULL;
    }
    public function testEvent()
    {
       $eventTest = new Eustatos\gitlab\webhook\Event(
          'echo "test"',
          'b2b pushed',
           $_SERVER
        );
        $this->expectOutputString("Result execution: echo \"test\"\n0\n<pre>Array\n(\n    [0] => test\n)\n</pre>");
        $eventTest->getResult();
    }
}
