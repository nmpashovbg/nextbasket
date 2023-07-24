<?php
declare(strict_types=1);

namespace Tests\Services;

use App\Config\RabbitMQConfig;
use App\Services\RabbitMQService;
use PhpAmqpLib\Channel\AbstractChannel;
use PhpAmqpLib\Message\AMQPMessage;
use PHPUnit\Framework\TestCase;
use Mockery;

class RabbitMQServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    /**
     * @throws \Exception
     */
    public function testPublishMethodPublishesMessageToRabbitMQ()
    {
        $channelMock = Mockery::mock(AbstractChannel::class);
        $configMock = Mockery::mock(RabbitMQConfig::class);

        $configMock->exchange = 'test_exchange';
        $configMock->routing_key = 'test_routing_key';

        $message = new AMQPMessage('test message');

        $channelMock->shouldReceive('basic_publish')
            ->with($message, 'test_exchange', 'test_routing_key')
            ->once();

        $rabbitMQService = new RabbitMQService($channelMock, $configMock);

        $this->assertNull($rabbitMQService->publish($message));
    }
}
