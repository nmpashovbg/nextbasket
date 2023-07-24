<?php
declare(strict_types=1);

namespace App\Contracts;

use PhpAmqpLib\Message\AMQPMessage;

/**
 * Interface LoggerInterface
 * @package App\Services
 */
interface MessageBrokerInterface
{
    public function publish(AMQPMessage $message): void;
}
