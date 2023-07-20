<?php
declare(strict_types=1);

namespace App\Services;

use App\Contracts\LoggerInterface;
use Illuminate\Support\Facades\Log;

/**
 * Class LoggerService
 * @package App\Services
 */
class LoggerService implements LoggerInterface
{
    public function log(string $data): void
    {
        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/user_creation.log'),
        ])->info($data);
    }
}
