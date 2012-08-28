<?php

namespace Spray\EventControllerBundle\Event;

use PHPUnit_Framework_TestCase as TestCase;
use Spray\EventControllerBundle\Event\Event;
use stdClass;

/**
 * EventTest
 *
 * @author MHWK
 */
class EventTest extends TestCase
{
    public function setUp()
    {
        $this->controller = $this->getMockBuilder('Symfony\Bundle\FrameworkBundle\Controller\Controller')
            ->disableOriginalConstructor()
            ->getMock();
    }
    
    protected function createEvent()
    {
        return new Event($this->controller);
    }
    
    public function testGetController()
    {
        $this->assertSame(
            $this->controller,
            $this->createEvent()->getController()
        );
    }
    
    public function testGetRequest()
    {
        $request = $this->getMockBuilder('Symfony\Component\HttpFoundation\Request')
            ->disableOriginalConstructor()
            ->getMock();
        $this->controller->expects($this->once())
            ->method('getRequest')
            ->will($this->returnValue($request));
        $this->assertSame(
            $request,
            $this->createEvent()->getRequest()
        );
    }
    
    public function testDefaultDataIsNull()
    {
        $this->assertNull($this->createEvent()->getData());
    }
    
    public function testSetData()
    {
        $data = new stdClass();
        $event = $this->createEvent();
        $event->setData($data);
        $this->assertSame($data, $event->getData());
    }
    
    public function testDefaultViewDataIsArrayObject()
    {
        $this->assertInstanceOf(
            'ArrayObject',
            $this->createEvent()->getViewData()
        );
    }
}