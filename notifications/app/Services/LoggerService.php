<?php
declare(strict_types=1);

namespace App\Services;

use App\Contracts\LoggerInterface;
use Psr\Log\LoggerInterface as PSRLoggerInterface;

/**
 * Class LoggerService
 * @package App\Services
 */
class LoggerService implements LoggerInterface
{
    public function __construct(protected PSRLoggerInterface $logger)
    {
        //
    }

    public function log(string $data): void
    {
        $this->logger->channel('nextBasket')->log('info', $data);
    }
}
