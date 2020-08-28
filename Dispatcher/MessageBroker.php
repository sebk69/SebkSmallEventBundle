<?php
/**
 * This file is a part of SebkSmallEventsBundle
 * Copyright 2020 - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallEventsBundle\Dispatcher;


use App\EventSubscriber\TestSubscriber;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Sebk\SmallEventsBundle\Event\SmallEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class MessageBroker
 * @package Sebk\SmallEventsBundle\Dispatcher
 */
class MessageBroker
{
    const EXCHANGE_NAME = "smallEvent";

    protected $config;

    /** @var AMQPStreamConnection */
    protected $connection;
    /** @var AMQPChannel */
    protected $channel;
    /** @var EventDispatcher */
    protected $dispatcher;

    /**
     * MessageBroker constructor.
     * @param array $config
     * @param EventDispatcher $dispatcher
     */
    public function __construct(array $config, EventDispatcher $dispatcher)
    {
        $this->config = $config;
        $this->dispatcher = $dispatcher;
        $this->connect();
    }

    /**
     * Connect to message broker
     */
    protected function connect()
    {
        $this->connection = new AMQPStreamConnection($this->config["rabbitmq_server"], 5672, $this->config["rabbitmq_login"], $this->config["rabbitmq_password"]);
        $this->channel = $this->connection->channel();
        $this->channel->exchange_declare($this->getExchangeName(), "fanout", false, true, false);
    }

    /**
     * Get Exchange name for sending messages
     * @return string
     */
    protected function getExchangeName()
    {
        return static::EXCHANGE_NAME;
    }

    /**
     * Get queue name for receiving message
     * @return string
     */
    protected function getQueueName()
    {
        return $this->getExchangeName()."_".$this->config["application_id"];
    }

    /**
     * Publish a message
     * @param AMQPMessage $message
     */
    public function publish(AMQPMessage $message)
    {
        $this->channel->basic_publish($message, $this->getExchangeName());
    }

    /**
     * Listen for message
     * @throws \ErrorException
     */
    public function listen()
    {
        $this->channel->queue_declare($this->getQueueName(), false, true, false, false);
        $this->channel->queue_bind($this->getQueueName(), $this->getExchangeName());

        $this->channel->basic_consume($this->getQueueName(), $this->config["application_id"], false, false, false, false, [$this, "consume"]);

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    /**
     * Consume message
     * @param AMQPMessage $message
     */
    public function consume(AMQPMessage $message)
    {
        $messageDecoded = json_decode($message->getBody(), true);

        $this->relayMessageToEvent($messageDecoded);

        $this->channel->basic_ack($message->getDeliveryTag(), false);
    }

    /**
     * Relay message to symfony dispatcher
     * @param $message
     * @throws \Exception
     */
    public function relayMessageToEvent($message)
    {
        $event = (new SmallEvent())
            ->setEventName($message["eventName"])
            ->setDateEmitted(new \DateTime($message["date"]))
            ->setData($message["data"])
        ;

        $this->dispatcher->dispatch($event, $event->getEventName());
    }

}