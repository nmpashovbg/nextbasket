<?php
declare(strict_types=1);
namespace App\Services;

use App\Config\RabbitMQConfig;
use App\Contracts\LoggerInterface;
use App\Contracts\MessageBrokerInterface;
use Exception;
use PhpAmqpLib\Channel\AbstractChannel;
use PhpAmqpLib\Channel\AMQPChannel;

class RabbitMQService implements MessageBrokerInterface
{
    /**
     * RabbitMQService constructor.
     * @param AMQPChannel $channel
     * @param RabbitMQConfig $config
     */
    public function __construct(
        private AbstractChannel $channel,
        private RabbitMQConfig $config,
        private LoggerInterface $logger,
    )
    {
    }
    /**
     * @throws Exception
     */
    public function consume(): void
    {
        $logger = $this->logger;

        $callback = function ($msg) use ($logger): void{
            echo ' [x] Received ', $msg->body, "\n";
            $logger->log($msg->body);
        };

        $this->channel->queue_declare($this->config->queue, false, false, false, false);
        $this->channel->basic_consume($this->config->queue, '', false, true, false, false, $callback);

        echo 'Waiting for new message on users_queue', " \n";
        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }
}
