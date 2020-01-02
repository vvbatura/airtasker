<?php

namespace App\Traits;

trait NexmoTrait
{

    public function initClient()
    {
        $basic  = new \Nexmo\Client\Credentials\Basic(env('NEXMO_KEY'), env('NEXMO_SECRET'));
        return new \Nexmo\Client($basic);
    }

    protected function sendSMS ($number, $message)
    {
        $client = $this->initClient();
        $message = $client->message()->send([
            'to' => $number,
            'from' => 'AirTasker',
            'text' => $message
        ]);
        return $message;
    }

}
