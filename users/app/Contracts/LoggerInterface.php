<?php
declare(strict_types=1);

namespace App\Contracts;

/**
 * Interface LoggerInterface
 * @package App\Services
 */
interface LoggerInterface
{
    public function log(string $data): void;
}
