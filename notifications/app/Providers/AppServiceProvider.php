<?php
declare(strict_types=1);

namespace App\Providers;

use App\Config\RabbitMQConfig;
use App\Contracts\LoggerInterface;
use App\Contracts\MessageBrokerInterface;
use App\Services\LoggerService;
use App\Services\RabbitMQService;
use Illuminate\Log\LogManager;
use Illuminate\Support\ServiceProvider;
use PhpAmqpLib\Channel\AbstractChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Psr\Log\LoggerInterface as PSRLoggerInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LoggerInterface::class, LoggerService::class);
        $this->app->bind(PSRLoggerInterface::class, LogManager::class);

        $this->app->singleton(RabbitMQConfig::class, function () {
            return new RabbitMQConfig();
        });

        $this->app->bind(AbstractChannel::class, function ($app) {
            $config = $app->make(RabbitMQConfig::class);

            $connection = new AMQPStreamConnection(
                $config->host,
                $config->port,
                $config->user,
                $config->password,
                $config->vhost
            );

            return $connection->channel();
        });

        $this->app->bind(MessageBrokerInterface::class, RabbitMQService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
