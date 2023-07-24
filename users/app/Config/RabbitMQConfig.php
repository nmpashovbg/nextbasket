<?php
declare(strict_types=1);

namespace App\Config;

class RabbitMQConfig
{
    public string $host;
    public int $port;
    public string $user;
    public string $password;
    public string $vhost;
    public string $exchange;
    public string $queue;
    public string $routing_key;

    public function __construct()
    {
        $this->host = env('RABBITMQ_HOST');
        $this->port = (int)env('RABBITMQ_PORT');
        $this->user = env('RABBITMQ_USER');
        $this->password = env('RABBITMQ_PASSWORD');
        $this->vhost = env('RABBITMQ_VHOST');
        $this->exchange = env('RABBITMQ_EXCHANGE_NAME');
        $this->queue = env('RABBITMQ_QUEUE');
        $this->routing_key = env('RABBITMQ_ROUTING_KEY');
    }
}
