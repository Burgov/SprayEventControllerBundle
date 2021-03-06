<?php

namespace Spray\EventControllerBundle\Event;

use ArrayObject;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\Event as DispatcherEvent;
use Symfony\Component\HttpFoundation\Request;

/**
 * Event
 */
class Event extends DispatcherEvent
{
    /**
     * Constants define available events
     */
    const CONTAINER_INJECT = 'container.inject';
    const INDEX            = 'action.index';
    const CREATE           = 'action.create';
    const UPDATE           = 'action.update';
    const DELETE           = 'action.delete';
    
    /**
     * @var Controller
     */
    private $controller;
    
    /**
     * @var array|object
     */
    private $data;
    
    /**
     * @var array|object
     */
    private $viewData;
    
    /**
     * Construct a new controller Event
     * 
     * @param Controller $controller
     */
    public function __construct(Controller $controller)
    {
        $this->controller = $controller;
    }
    
    /**
     * Get the controller
     * 
     * @return Controller
     */
    public function getController()
    {
        return $this->controller;
    }
    
    /**
     * Get request from controller
     * 
     * @return Request
     */
    public function getRequest()
    {
        return $this->getController()->getRequest();
    }
    
    /**
     * Set data
     * 
     * @param array|object $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
    
    /**
     * Get data
     * 
     * @return array|object
     */
    public function getData()
    {
        return $this->data;
    }
    
    /**
     * Set view data
     * 
     * @param array|object $viewData
     */
    public function setViewData($viewData)
    {
        $this->viewData = $viewData;
    }
    
    /**
     * Get view data
     * 
     * @return array|object
     */
    public function getViewData()
    {
        if (null === $this->viewData) {
            $this->setViewData(new ArrayObject());
        }
        return $this->viewData;
    }
}