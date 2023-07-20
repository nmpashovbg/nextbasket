<?php
declare(strict_types=1);
namespace App\Services;

use App\Contracts\LoggerInterface;
use App\Contracts\RabbitMQServiceInterface;
use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQService implements RabbitMQServiceInterface
{
    /**
     * @throws Exception
     */
    public function consume(LoggerInterface $logger): void
    {
        $connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST'),
            env('RABBITMQ_PORT'),
            env('RABBITMQ_USER'),
            env('RABBITMQ_PASSWORD'),
            env('RABBITMQ_VHOST')
        );

        $channel = $connection->channel();

        $callback = function ($msg) use ($logger): void{
            echo ' [x] Received ', $msg->body, "\n";
            $logger->log($msg->body);
        };

        $channel->queue_declare(env('RABBITMQ_QUEUE'), false, false, false, false);
        $channel->basic_consume(env('RABBITMQ_QUEUE'), '', false, true, false, false, $callback);

        echo 'Waiting for new message on users_queue', " \n";
        while ($channel->is_consuming()) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }
}
