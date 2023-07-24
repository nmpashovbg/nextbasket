<?php
declare(strict_types=1);

namespace Tests\Services;

use Mockery;
use Psr\Log\LoggerInterface;
use Tests\TestCase;
use App\Services\LoggerService;

class LoggerServiceTest extends TestCase
{
    protected LoggerInterface $loggerMock;

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testLogMethodLogsDataUsingLogger()
    {
        $data = 'test log data';

        $loggerMock = Mockery::mock(LoggerInterface::class);
        $channelMock = Mockery::mock();

        $loggerMock->shouldReceive('channel')->with('nextBasket')->andReturn($channelMock);
        $channelMock->shouldReceive('log')->with('info', $data)->once();

        $loggerService = new LoggerService($loggerMock);
        $this->assertNull($loggerService->log($data));
    }
}
