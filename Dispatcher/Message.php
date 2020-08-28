<?php
/**
 * This file is a part of SebkSmallEventsBundle
 * Copyright 2020 - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallEventsBundle\Dispatcher;


use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class Message
 * @package Sebk\SmallEventsBundle\Dispatcher
 */
class Message
{
    protected $class;
    protected $eventName;
    protected $date;
    protected $data;

    /**
     * Message constructor.
     * @param string $eventName
     * @param $data
     */
    public function __construct(string $eventName, $data)
    {
        $this->eventName = $eventName;
        $this->data = $data;
        $this->date = new \DateTime();
    }

    /**
     * Convert message to rabbitmq format
     * @return AMQPMessage
     */
    public function getRabbitMqMessage(): AMQPMessage
    {
        return new AMQPMessage(json_encode([
            "eventName" => $this->eventName,
            "date" => $this->date->format("Y-m-d H:i:s"),
            "data" => $this->data,
        ]));
    }
}