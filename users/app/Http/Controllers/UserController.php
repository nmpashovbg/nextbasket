<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\MessageBrokerInterface;
use App\Events\UserCreated;
use App\Contracts\LoggerInterface;
use App\Jobs\UserQueue;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use PhpAmqpLib\Message\AMQPMessage;

class UserController extends Controller
{
    public function __construct(protected LoggerInterface $logger, protected MessageBrokerInterface $messageBroker)
    {
    }

    /**
     * Create a new user.
     *
     * @param  Request  $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function createUser(Request $request): JsonResponse
    {
        $this->validate($request, [
            'email' => 'required|email',
            'firstName' => 'required|string',
            'lastName' => 'required|string',
        ]);

        $logMessage = sprintf(
            "User created: %s %s [%s]",
            $request->get('firstName'),
            $request->get('lastName'),
            $request->get('email')
        );

        $this->logger->log($logMessage);
        $this->messageBroker->publish(
            new AMQPMessage(json_encode([
                'firstName' => $request->get('firstName'),
                'lastName' => $request->get('lastName'),
                'email' => $request->get('email')
            ]))
        );

        return response()->json(['message' => 'User created successfully']);
    }
}
