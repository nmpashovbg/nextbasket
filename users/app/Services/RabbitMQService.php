<?php

namespace App\Services;

use App\Contracts\RabbitMQServiceInterface;
use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQService implements RabbitMQServiceInterface
{
    /**
     * @throws Exception
     */
    public function publish(string $message): void
    {
        $connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST'),
            env('RABBITMQ_PORT'),
            env('RABBITMQ_USER'),
            env('RABBITMQ_PASSWORD'),
            env('RABBITMQ_VHOST')
        );

        $channel = $connection->channel();
        $channel->exchange_declare(env('RABBITMQ_EXCHANGE_NAME'), 'direct', false, false, false);
        $channel->queue_declare(env('RABBITMQ_QUEUE'), false, false, false, false);
        $channel->queue_bind(env('RABBITMQ_QUEUE'), env('RABBITMQ_EXCHANGE_NAME'), 'test_key');

        $msg = new AMQPMessage($message);
        $channel->basic_publish($msg, env('RABBITMQ_EXCHANGE_NAME'), 'test_key');

        $channel->close();
        $connection->close();
    }
}
