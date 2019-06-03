<?php

namespace App\Listeners;

use App\Events\NewUser;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Reputation;

class MakeReputationRecord
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    { }

    /**
     * Handle the event.
     *
     * @param  NewUser  $event
     * @return void
     */
    public function handle(NewUser $event)
    {

        $user = $event->User;

        $rep = new Reputation;

        $rep->discord_id = $user->discord_id;

        $rep->save();
    }
}