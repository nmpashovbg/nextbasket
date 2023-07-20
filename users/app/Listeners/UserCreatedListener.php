<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class UserCreatedListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        // Retrieve the user data from the event
        $user = $event->user;

        // Log the user data in a log file
        $this->logUser($user);
    }

    /**
     * Log the user data in a log file.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    private function logUser($user)
    {
        // Customize the log file path as per your needs
        $logFilePath = storage_path('logs/user_notification.log');

        $logMessage = sprintf(
            "[%s] User notification: %s %s <%s>",
            now()->format('Y-m-d H:i:s'),
            $user->first_name,
            $user->last_name,
            $user->email
        );

        // Log the message to the file
        Log::info($logMessage, [], $logFilePath);
    }
}
