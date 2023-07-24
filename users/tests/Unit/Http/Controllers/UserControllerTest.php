<?php
declare(strict_types=1);

namespace Tests\Http\Controllers;

use App\Contracts\LoggerInterface;
use App\Contracts\MessageBrokerInterface;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Mockery;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    private MockObject $loggerMock;
    private MockObject $rabbitMQServiceMock;
    private MockObject $request;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->loggerMock = $this->createMock(LoggerInterface::class);
        $this->rabbitMQServiceMock = $this->createMock(MessageBrokerInterface::class);
        $this->request = $this->createMock(Request::class);
    }

    public function testUserCreationOK(): void
    {
        $requestData = [
            'email' => 'test@example.com',
            'firstName' => 'John',
            'lastName' => 'Doe',
        ];

        $logMessage = sprintf(
            "User created: %s %s [%s]",
            $requestData['firstName'],
            $requestData['lastName'],
            $requestData['email'],
        );

        $this->loggerMock->expects($this->once())
            ->method('log')
            ->with($logMessage);

        $this->rabbitMQServiceMock->expects($this->once())
            ->method('publish')
            ->withAnyParameters();

        $this->request->expects($this->exactly(6))
            ->method('get')
            ->willReturnOnConsecutiveCalls(
                $requestData['firstName'], $requestData['lastName'], $requestData['email'],
                $requestData['firstName'], $requestData['lastName'], $requestData['email']
            );

        $this->request->expects($this->once())
            ->method('all')
            ->willReturn($requestData);

        $controller = new UserController($this->loggerMock, $this->rabbitMQServiceMock);

        $response = $controller->createUser($this->request);
        $this->assertSame(['message' => 'User created successfully'], $response->getData(true));
    }

    public function testValidationUserCreationError(): void
    {
        $controller = new UserController($this->loggerMock, $this->rabbitMQServiceMock);

        $requestData = [
            'email' => '',
            'firstName' => '',
            'lastName' => '',
        ];

        $this->request->expects($this->once())
            ->method('all')
            ->willReturn($requestData);

        try {
            $controller->createUser($this->request);
        } catch (ValidationException $e) {
            $this->assertEquals([
                'email' => ['The email field is required.'],
                'firstName' => ['The first name field is required.'],
                'lastName' => ['The last name field is required.'],
            ], $e->errors());
        }
    }

    public function testFirstNameRequired(): void
    {
        $requestData = [
            'email' => 'test@example.com',
            'firstName' => '', // Empty first name
            'lastName' => 'Doe',
        ];

        $this->request->expects($this->once())
            ->method('all')
            ->willReturn($requestData);

        try {
            $controller = new UserController($this->loggerMock, $this->rabbitMQServiceMock);
            $controller->createUser($this->request);
        } catch (ValidationException $e) {
            $this->assertEquals(['firstName' => ['The first name field is required.']], $e->errors());
        }
    }

    public function testLastNameRequired(): void
    {
        $requestData = [
            'email' => 'test@example.com',
            'firstName' => 'John',
            'lastName' => '', // Empty last name
        ];

        $this->request->expects($this->once())
            ->method('all')
            ->willReturn($requestData);

        try {
            $controller = new UserController($this->loggerMock, $this->rabbitMQServiceMock);
            $controller->createUser($this->request);
        } catch (ValidationException $e) {
            $this->assertEquals(['lastName' => ['The last name field is required.']], $e->errors());
        }
    }

    public function testEmailRequired(): void
    {
        $requestData = [
            'email' => '', // Empty email
            'firstName' => 'John',
            'lastName' => 'Doe',
        ];

        $this->request->expects($this->once())
            ->method('all')
            ->willReturn($requestData);

        try {
            $controller = new UserController($this->loggerMock, $this->rabbitMQServiceMock);
            $controller->createUser($this->request);
        } catch (ValidationException $e) {
            $this->assertEquals(['email' => ['The email field is required.']], $e->errors());
        }
    }

    public function testInvalidEmailFormat(): void
    {
        $requestData = [
            'email' => 'invalid-email', // Invalid email format
            'firstName' => 'John',
            'lastName' => 'Doe',
        ];

        $this->request->expects($this->once())
            ->method('all')
            ->willReturn($requestData);

        try {
            $controller = new UserController($this->loggerMock, $this->rabbitMQServiceMock);
            $controller->createUser($this->request);
        } catch (ValidationException $e) {
            $this->assertEquals(['email' => ['The email field must be a valid email address.']], $e->errors());
        }
    }

    public function testValidUserData(): void
    {
        $requestData = [
            'email' => 'test@example.com',
            'firstName' => 'John',
            'lastName' => 'Doe',
        ];

        $logMessage = sprintf(
            "User created: %s %s [%s]",
            $requestData['firstName'],
            $requestData['lastName'],
            $requestData['email'],
        );

        $this->loggerMock->expects($this->once())
            ->method('log')
            ->with($logMessage);

        $this->rabbitMQServiceMock->expects($this->once())
            ->method('publish')
            ->withAnyParameters();

        $this->request->expects($this->exactly(6))
            ->method('get')
            ->willReturnOnConsecutiveCalls(
                $requestData['firstName'], $requestData['lastName'], $requestData['email'],
                $requestData['firstName'], $requestData['lastName'], $requestData['email']
            );

        $this->request->expects($this->once())
            ->method('all')
            ->willReturn($requestData);

        $controller = new UserController($this->loggerMock, $this->rabbitMQServiceMock);

        $response = $controller->createUser($this->request);
        $this->assertSame(['message' => 'User created successfully'], $response->getData(true));
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }
}

