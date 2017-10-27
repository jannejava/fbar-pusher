<?php

namespace Eastwest\FBar\Commands;

use Eastwest\FBar\Push;
use Illuminate\Console\Command;

class PushCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'fbar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Push a message to F-Bar';

    /**
     * Command signature
     * @var string
     */
    protected $signature = 'fbar:push {--message=} {--device=}';

    /**
     * Pusher instance
     * @var Eastwest\FBar\Pusher
     */
    protected $pusher;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $message = $this->option('message');

        if($message == null) {
            $message = sprintf("%s deployed successfully", env('APP_NAME') ?? env('APP_URL'));
        }
        
        $pusher = new Push($message, $this->option('device'));
        try {
            $pusher->sendRequest();
        } catch (Exception $exception) {
            consoleOutput()->error("Push failed because: {$exception->getMessage()}.");
            return -1;
        }
    }
}