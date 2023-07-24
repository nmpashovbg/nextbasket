<?php
declare(strict_types=1);

namespace Tests\Console\Commands;

use App\Console\Commands\ConsumerCommand;
use App\Contracts\MessageBrokerInterface;
use Illuminate\Console\Command;
use PHPUnit\Framework\TestCase;
use Mockery;

class ConsumerCommandTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testHandleMethodCallsMessageBrokerInterfaceConsume()
    {
        $messageBrokerMock = Mockery::mock(MessageBrokerInterface::class);
        $messageBrokerMock->shouldReceive('consume')->once();

        $consumerCommand = new ConsumerCommand($messageBrokerMock);
        $result = $consumerCommand->handle();

        $this->assertEquals(Command::SUCCESS, $result);
    }
}

