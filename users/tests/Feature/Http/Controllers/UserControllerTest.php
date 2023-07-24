<?php
namespace Tests\Feature;

use Illuminate\Support\Env;
use Tests\TestCase;
use Mockery;

class UserControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testUserCreationOK(): void
    {
        $requestData = [
            'email' => 'test@example.com',
            'firstName' => 'John',
            'lastName' => 'Doe',
        ];

        $response = $this->postJson('/api/users', $requestData);

        $response->assertStatus(200);
        $response->assertExactJson(['message' => 'User created successfully']);
    }

    public function testValidationUserCreationError(): void
    {
        $requestData = [
            'email' => '',
            'firstName' => '',
            'lastName' => '',
        ];

        $response = $this->postJson('/api/users', $requestData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email', 'firstName', 'lastName']);
    }

    public function testEmailFieldRequired(): void
    {
        $requestData = [
            'email' => '',
            'firstName' => 'John',
            'lastName' => 'Doe',
        ];

        $response = $this->postJson('/api/users', $requestData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    public function testFirstNameFieldRequired(): void
    {
        $requestData = [
            'email' => 'test@example.com',
            'firstName' => '',
            'lastName' => 'Doe',
        ];

        $response = $this->postJson('/api/users', $requestData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['firstName']);
    }

    public function testLastNameFieldRequired(): void
    {
        $requestData = [
            'email' => 'test@example.com',
            'firstName' => 'John',
            'lastName' => '',
        ];

        $response = $this->postJson('/api/users', $requestData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['lastName']);
    }

    protected function setUp(): void
    {
        parent::setUp();
        Env::getRepository()->set('RABBITMQ_HOST', 'localhost');
    }
}
