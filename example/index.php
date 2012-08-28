<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use Spray\EventControllerBundle\Controller\AbstractEventController;
use Spray\EventControllerBundle\Event\Event;
use Spray\EventControllerBundle\EventListener\DoctrineListener;

class MyController extends AbstractEventController
{
    public function __construct()
    {
        $this->getEventDispatcher()->addSubscriber(
            new DoctrineListener($this->getDoctrine()->getEntityManager())
        );
    }
    
    /**
     * @Template
     */
    public function indexAction()
    {
        $event = new Event($this);
        return $this->dispatch(Event::INDEX, $event)->getViewData();
    }
    
    /**
     * @Template
     */
    public function createAction()
    {
        $event = new Event($this);
        
        $this->dispatch(Event::CREATE, $event);
        if ($event->isPropagationStopped()) {
            return $event->getViewData();
        }
        
        return $this->redirect($this->generateUrl('my_index'));
    }
}