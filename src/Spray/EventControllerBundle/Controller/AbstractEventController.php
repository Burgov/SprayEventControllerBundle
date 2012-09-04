<?php

namespace Spray\EventControllerBundle\Controller;

use Spray\EventControllerBundle\Event\Event;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * EventController
 */
abstract class AbstractEventController extends Controller
{
    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;
    
    /**
     * Set the event dispatcher
     * 
     * @param EventDispatcher $eventDispatcher
     */
    public function setEventDispatcher(EventDispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }
    
    /**
     * Get the event dispatcher
     * 
     * @return EventDispatcher
     */
    public function getEventDispatcher()
    {
        if (null === $this->eventDispatcher) {
            $this->setEventDispatcher(new EventDispatcher());
        }
        return $this->eventDispatcher;
    }
    
    /**
     * Dispatch an event when the container is injected
     * 
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->dispatch(Event::CONTAINER_INJECT, new Event());
    }
    
    /**
     * Dispatch event through the event dispatcher
     * 
     * @param string $eventName
     * @param Event $event
     * @return Event
     */
    public function dispatch($eventName, Event $event)
    {
        $this->getEventDispatcher()->dispatch($eventName, $event);
        return $event;
    }
}