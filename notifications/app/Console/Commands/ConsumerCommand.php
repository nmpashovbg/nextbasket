<?php
declare(strict_types=1);
namespace App\Console\Commands;

use App\Contracts\LoggerInterface;
use App\Contracts\RabbitMQServiceInterface;
use Illuminate\Console\Command;

class ConsumerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:consumer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'RabbitMQ Consumer';

    public function __construct(protected RabbitMQServiceInterface $rabbitMQService, protected LoggerInterface $logger)
    {
        parent::__construct();
    }

    /**
     * @return int
     */
    public function handle(): int
    {
        $this->rabbitMQService->consume($this->logger);

        return Command::SUCCESS;
    }
}
