<?php

namespace Eastwest\FBar;

use Eastwest\FBar\Exceptions\InvalidCommand;
use GuzzleHttp\Client;

class Push
{
    const BASE_URL = 'http://pusher.dev';
    
    public function __construct($message, $deviceId = null) 
    {
        $this->message = $message;
        $this->deviceId = $deviceId;
        
        $this->guardAgaistNullDeviceId();

        return $this;
    }

    public function url()
    {
        return sprintf('%s/api/v1/device/%s/push', ltrim(self::BASE_URL, '/'), $this->deviceId);
    }

    public function parameters() 
    {
        return [
            'form_params' => [
                'message' => $this->message
            ]
        ];
    }

    public function sendRequest() 
    { 
        $result = (new Client())
                    ->post($this->url(), $this->parameters());

        return $result;
    }

    protected function guardAgaistNullDeviceId() 
    {
        if($this->deviceId == null) {

            $config = config('laravel-fbar');

            if(!isset($config['deviceId']) || $config['deviceId'] == null) {
                throw InvalidCommand::create('Device ID cannot be null'); 
            }

            $deviceId = $config['deviceId'];
        }
    }
}