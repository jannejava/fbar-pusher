<?php

namespace Eastwest\FBar\Listeners;

use Eastwest\FBar\Push;

class BackupNotifications
{
    public function success($event) 
    {
    	$this->sendRequest("Backup of " . config('app.name') . " was successful.");
    }

    public function failed($event) 
    {
    	$this->sendRequest("Backup of " . config('app.name') . " was successful.");
    }

    protected function sendRequest($message) 
    {
    	$pusher = new Push($message);
        try {
            $pusher->sendRequest();
        } catch (Exception $exception) {
            consoleOutput()->error("Push failed because: {$exception->getMessage()}.");
            return -1;
        }
    }
	
	public function subscribe($events)
    {
        $events->listen(
            'Spatie\Backup\Events\BackupWasSuccessful',
            'Eastwest\FBar\Listeners\BackupNotifications@success'
        );

        $events->listen(
            'Spatie\Backup\Events\BackupHasFailed',
            'Eastwest\FBar\Listeners\BackupNotifications@failed'
        );
    }
}