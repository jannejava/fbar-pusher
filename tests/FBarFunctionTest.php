<?php

namespace Eastwest\FBar\Test;

use FBar;

class FBarFunctionTest extends TestCase
{
    /** @test */
    public function url_is_correct()
    {
        $message = "My message";
        $device = "my-device-id";

    	$fbar = new \Eastwest\FBar\Push("My message", "my-device-id");

        $this->assertSame($fbar->url(), "http://pusher.dev/api/v1/device/my-device-id/push");
    }

    /** @test */
    public function params_is_correct()
    {
        $message = "My message";
        $device = "my-device-id";

        $fbar = new \Eastwest\FBar\Push("My message", "my-device-id");

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
        $message = "My message";

        $fbar = new \Eastwest\FBar\Push("My message", null);


    }
}