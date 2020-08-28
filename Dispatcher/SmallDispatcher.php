<?php


namespace Sebk\SmallEventsBundle\Dispatcher;


use PhpAmqpLib\Message\AMQPMessage;
use Sebk\SmallEventsBundle\Event\SmallEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;

class SmallDispatcher
{
    protected $messageBroker;
    protected $symfonyDispatcher;

    public function __construct(MessageBroker $messageBroker, EventDispatcher $symfonyDispatcher)
    {
        $this->messageBroker = $messageBroker;
        $this->symfonyDispatcher = $symfonyDispatcher;
    }

    public function dispatch(SmallEvent $event)
    {
        $message = new Message($event->getEventName(), $event->getData());

        $this->messageBroker->publish($message->getRabbitMqMessage());
    }

}