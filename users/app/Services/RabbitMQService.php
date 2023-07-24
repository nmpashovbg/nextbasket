<?php
declare(strict_types=1);

namespace App\Services;

use App\Config\RabbitMQConfig;
use App\Contracts\MessageBrokerInterface;
use Exception;
use PhpAmqpLib\Channel\AbstractChannel;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQService implements MessageBrokerInterface
{
    /**
     * RabbitMQService constructor.
     * @param AMQPChannel $channel
     * @param RabbitMQConfig $config
     */
    public function __construct(
        private AbstractChannel $channel,
        private RabbitMQConfig $config
    )
    {
    }

    /**
     * @throws Exception
     */
    public function publish(AMQPMessage $message): void
    {
        $this->channel->basic_publish($message, $this->config->exchange, $this->config->routing_key);
    }
}
