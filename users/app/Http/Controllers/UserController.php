<?php

namespace App\Http\Controllers;

use App\Events\UserCreated;
use App\Contracts\LoggerInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function __construct(protected LoggerInterface $logger)
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
            "[%s] User created: %s %s [%s]",
            now()->format('Y-m-d H:i:s'),
            $request->get('firstName'),
            $request->get('lastName'),
            $request->get('email')
        );

        $this->logger->log($logMessage);

        event(new UserCreated($request->all()));

        return response()->json(['message' => 'User created successfully']);
    }
}
