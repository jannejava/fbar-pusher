<?php

namespace Eastwest\FBar\Test;

use FBar;

class FBarFunctionTest extends TestCase
{
    /** @test */
    public function url_is_correct()
    {
        $device = "my-test-device-id";
    	$fbar = new \Eastwest\FBar\Push("My test message", $device);
        $this->assertSame($fbar->url(), "http://pusher.dev/api/v1/device/{$device}/push");
    }

    /** @test */
    public function params_is_correct()
    {
        $message = "My test message";

        $fbar = new \Eastwest\FBar\Push($message, "my-device-id");

        $this->assertSame($fbar->parameters(), [
            'form_params' => [
                'message' => $message
            ]
        ]);
    }

    /** @test 
    * @expectedException Eastwest\FBar\Exceptions\InvalidCommand
    */
    public function null_device_id_is_not_valid()
    {
        $fbar = new \Eastwest\FBar\Push("My message", null);
    }

    /** @test */
    public function send_valid_device_id()
    {
        $fbar = new \Eastwest\FBar\Push("My message", "my-test-device-id");
        $response = $fbar->sendRequest();

        $this->assertSame($response->getStatusCode(), 200);
    }

    /** @test 
     * @expectedException GuzzleHttp\Exception\ClientException
     */
    public function send_invalid_device_id()
    {
        $fbar = new \Eastwest\FBar\Push("My message", "my-invalid-id");
        $response = $fbar->sendRequest();

        $this->assertSame($response->getStatusCode(), 404);
    }

    /** @test */
    public function device_id_guard_is_reading_config()
    {
        $deviceId = "my-device-id";
        config(['laravel-fbar.deviceId' => $deviceId]);

        $fbar = new \Eastwest\FBar\Push("My message");

        $this->assertSame($fbar->deviceId, $deviceId);
    }
}