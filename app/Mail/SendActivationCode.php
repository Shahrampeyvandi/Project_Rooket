<?php

namespace App\Mail;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendActivationCode extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $code;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user , $code)
    {
        $this->user = $user;
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('لینک فعال سازی')->markdown('emails.active-user');
    }
}
