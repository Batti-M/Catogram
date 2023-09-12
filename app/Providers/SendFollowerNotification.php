<?php

namespace App\Providers;

use App\Mail\NewFollower;
use App\Providers\FollowerGained;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendFollowerNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    use InteractsWithQueue;
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(FollowerGained $event)
    {
        //dd($event->follower);
        Mail::to($event->followed->getAttribute('email'))->send(new NewFollower($event->follower, $event->followed));
    }
}
