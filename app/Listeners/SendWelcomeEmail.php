<?php

namespace App\Listeners;

use App\Mail\WelcomeMail;
use App\Events\UserSignup;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    public $delay = 60;

    public function handle(UserSignup $event): void
    {
        Mail::to($event->user->email)->send(new WelcomeMail($event->user));
    }
}
