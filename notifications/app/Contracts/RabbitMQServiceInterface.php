<?php
declare(strict_types=1);

namespace App\Contracts;

/**
 * Interface LoggerInterface
 * @package App\Services
 */
interface RabbitMQServiceInterface
{
    public function consume(LoggerInterface $logger): void;
}
