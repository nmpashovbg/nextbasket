<?php

namespace Tests\Services;

use App\Config\RabbitMQConfig;
use App\Contracts\LoggerInterface;
use App\Services\RabbitMQService;
use PhpAmqpLib\Channel\AbstractChannel;
use PHPUnit\Framework\TestCase;
use Mockery;

class RabbitMQServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testConsumeMethodConsumesMessagesFromRabbitMQAndLogsThem()
    {
        $channelMock = Mockery::mock(AbstractChannel::class);
        $configMock = Mockery::mock(RabbitMQConfig::class);
        $loggerMock = Mockery::mock(LoggerInterface::class);

        $configMock->queue = 'test_queue';

        $channelMock->shouldReceive('queue_declare')->with('test_queue', false, false, false, false)->once();
        $channelMock->shouldReceive('basic_consume')->with('test_queue', '', false, true, false, false, Mockery::type('callable'))->once();
        $channelMock->shouldReceive('is_consuming')->once();

        $rabbitMQService = new RabbitMQService($channelMock, $configMock, $loggerMock);
        $this->assertNull($rabbitMQService->consume());
    }
}
