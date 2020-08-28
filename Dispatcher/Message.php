<?php


namespace Sebk\SmallEventsBundle\Dispatcher;


use PhpAmqpLib\Message\AMQPMessage;

class Message
{
    protected $class;
    protected $eventName;
    protected $date;
    protected $data;

    public function __construct(string $eventName, $data)
    {
        $this->eventName = $eventName;
        $this->data = $data;
        $this->date = new \DateTime();
    }

    public function getRabbitMqMessage(): AMQPMessage
    {
        return new AMQPMessage(json_encode([
            "eventName" => $this->eventName,
            "date" => $this->date->format("Y-m-d H:i:s"),
            "data" => $this->data,
        ]));
    }
}