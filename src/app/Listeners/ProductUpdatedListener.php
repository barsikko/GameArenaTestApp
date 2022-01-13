<?php

namespace App\Listeners;

use App\Events\ProductUpdated;
use App\Notifications\ProductUpdatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class ProductUpdatedListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(ProductUpdated $event)
    {
        Notification::route('mail', env('MAIL_ADDRESS'))->notify(new ProductUpdatedNotification($event->product));
    }
}
