<?php


namespace Sebk\SmallEventsBundle\Events;


use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class MessageBroker
{
    protected $config;

    /** @var AMQPStreamConnection */
    protected $connection;
    /** @var AMQPChannel */
    protected $channel;

    public function __construct($config)
    {
        $this->config = $config;
    }

    protected function connect()
    {
        var_dump($this->config["rabbitmq_login"]);
        var_dump($this->config["rabbitmq_password"]);
        $this->connection = new AMQPStreamConnection($this->config["rabbitmq_server"], 5672, $this->config["rabbitmq_login"], $this->config["rabbitmq_password"]);
        $this->channel = $this->connection->channel();
    }

    public function createQueues()
    {
        $this->connect();
    }
}