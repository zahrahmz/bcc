<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $mobileNumber;
    protected $message;


    public function __construct($mobileNumber, $message)
    {
        $this->mobileNumber = $mobileNumber;
        $this->message = $message;
    }


    public function handle()
    {
        (new Client)->request('POST', 'http://api.smsapp.ir/v2/sms/send/simple', [
            'headers' => [
                'apikey' => '9bQPFjT8P/UB3mhGOJGYO0/aASU/STCCZ1lk+ECNvq0'
            ],
            'json' => [
                'message' => $this->message,
                'sender' => '30005066962957',
                'Receptor' => $this->mobileNumber,
            ]
        ]);
    }
}
