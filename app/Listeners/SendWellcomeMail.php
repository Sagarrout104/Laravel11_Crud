<?php

namespace App\Listeners;

use App\Events\UserRegister;
use App\Jobs\PostJob;
use App\Mail\WellcomeMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendWellcomeMail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegister $event): void
    {
        // PostJob::dispatch($event->email);

        Mail::to($event->email)->send(new WellcomeMail());
    }
}
