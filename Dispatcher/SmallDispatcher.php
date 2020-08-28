<?php
/**
 * This file is a part of SebkSmallEventsBundle
 * Copyright 2020 - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallEventsBundle\Dispatcher;


use PhpAmqpLib\Message\AMQPMessage;
use Sebk\SmallEventsBundle\Event\SmallEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class SmallDispatcher
 * @package Sebk\SmallEventsBundle\Dispatcher
 */
class SmallDispatcher
{
    protected $messageBroker;
    protected $symfonyDispatcher;

    /**
     * SmallDispatcher constructor.
     * @param MessageBroker $messageBroker
     * @param EventDispatcher $symfonyDispatcher
     */
    public function __construct(MessageBroker $messageBroker, EventDispatcher $symfonyDispatcher)
    {
        $this->messageBroker = $messageBroker;
        $this->symfonyDispatcher = $symfonyDispatcher;
    }

    /**
     * Dispatch event to message broker
     * @param SmallEvent $event
     */
    public function dispatch(SmallEvent $event)
    {
        $message = new Message($event->getEventName(), $event->getData());

        $this->messageBroker->publish($message->getRabbitMqMessage());
    }

}