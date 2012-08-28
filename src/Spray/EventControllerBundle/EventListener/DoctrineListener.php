<?php

namespace Spray\EventControllerBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;
use Spray\EventControllerBundle\Event\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * DoctrineListner
 */
class DoctrineListener implements EventSubscriberInterface
{
    /**
     * @var ObjectManager
     */
    private $objectManager;
    
    /**
     * Construct a new DoctrineListener
     * 
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }
    
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            Event::CREATE => array(
                array('persist', 0),
                array('flush', 0)
            ),
            Event::UPDATE => array(
                array('flush', 0)
            ),
            Event::DELETE => array(
                array('remove', 0),
                array('flush', 0)
            )
        );
    }
    
    /**
     * Persist $event->getData()
     * 
     * @param Event $event
     */
    public function persist(Event $event)
    {
        $this->objectManager->persist($event->getData());
    }
    
    /**
     * Remove $event->getData()
     * 
     * @param Event $event
     */
    public function remove(Event $event)
    {
        $this->objectManager->remove($event->getData());
    }
    
    /**
     * Flush the object manager
     * 
     * @param Event $event
     */
    public function flush(Event $event)
    {
        $this->objectManager->flush();
    }
}