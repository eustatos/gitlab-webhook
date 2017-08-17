<?php
class EventTest extends PHPUnit_Framework_TestCase
{
    private $event;
    
    public function setUp()
    {
        $this->event = new Event(
          'ls -la',
          'Gfhjkm123'
        );
    }
    public function tearDown()
    {
        $this->event = NULL;
    }
    public function testHelloWorld()
    {
        $eventTest = new Event(
          'ls -la',
          'b2b pushed'
        );
        $this->assertEquals('ls -la', $eventTest->command);
    }
}
