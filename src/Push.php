<?php

namespace Eastwest\FBar;

use Eastwest\FBar\Exceptions\InvalidCommand;
use GuzzleHttp\Client;

class Push
{
    /**
     * URL to F-Bar Push server
     */
    const BASE_URL = 'https://pusher.eastwest.se';
    
    /**
     * Construct Push Notification
     * @param string $message  Message sent to client
     * @param string $deviceId Unique device ID for receiver
     */
    public function __construct($message, $deviceId = null) 
    {
        $this->message = $message;
        $this->deviceId = $deviceId;
        
        $this->guardAgaistNullDeviceId();

        return $this;
    }

    /**
     * Construct URL to F-Bar Push server
     * @return String
     */
    public function url()
    {
        return sprintf('%s/api/v1/device/%s/push', ltrim(self::BASE_URL, '/'), $this->deviceId);
    }

    /**
     * Construct Guzzle parameters
     * @return array
     */
    public function parameters() 
    {
        return [
            'form_params' => [
                'message' => $this->message
            ]
        ];
    }

    /**
     * Create and send request with Guzzle
     * @return [type] [description]
     */
    public function sendRequest() 
    { 
        $result = (new Client())
                    ->post($this->url(), $this->parameters());

        return $result;
    }

    /**
     * Check that Device ID is not null, or throw exeption
     * @return null
     */
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