<?php

namespace App\Listeners\UserActivation;

use App\Events\UserActivation;

use GuzzleHttp\Client;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class sendSMSnotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserActivation  $event
     * @return void
     */
    public function handle(UserActivation $event)
    {

        $client = new Client([
            'verify' =>false,
        ]);

        $response = $client->request('POST' , 'https://api.kavenegar.com/v1/7345753639564B705137654C55547468506264663452413179447A567441726D/sms/send.json' , [
            'form_params' => [
                'receptor' => $event->user->phone,
                'message' => route('activation.account',$event->activationCode)
            ]
        ]);

    }
}
