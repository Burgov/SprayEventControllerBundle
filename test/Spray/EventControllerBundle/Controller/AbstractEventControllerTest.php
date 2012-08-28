<?php

namespace Spray\EventControllerBundle\Event;

use PHPUnit_Framework_TestCase as TestCase;

/**
 * AbstractEventControllerTest
 *
 * @author MHWK
 */
class AbstractEventControllerTest extends TestCase
{
    private $eventDispatcher;
    private $event;
    
    public function setUp()
    {
        $this->eventDispatcher = $this->getMockBuilder('Symfony\Component\EventDispatcher\EventDispatcher')
            ->disableOriginalConstructor()
            ->getMock();
        $this->event = $this->getMockBuilder('Spray\EventControllerBundle\Event\Event')
            ->disableOriginalConstructor()
            ->getMock();
    }
    
    protected function createController($inject = true)
    {
        $controller = $this->getMockBuilder('Spray\EventControllerBundle\Controller\AbstractEventController')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        if ($inject) {
            $controller->setEventDispatcher($this->eventDispatcher);
        }
        return $controller;
    }
    
    public function testDefaultEventDispatcher()
    {
        $this->assertInstanceOf(
            'Symfony\Component\EventDispatcher\EventDispatcher',
            $this->createController(false)->getEventDispatcher()
        );
    }
    
    public function testDispatchEvent()
    {
        $this->eventDispatcher->expects($this->once())
            ->method('dispatch')
            ->with(
                $this->equalTo(Event::INDEX),
                $this->equalTo($this->event));
        $this->assertSame(
            $this->event,
            $this->createController()->dispatch(Event::INDEX, $this->event)
        );
    }
}