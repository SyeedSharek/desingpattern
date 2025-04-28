<?php

namespace App\Listeners;

use App\Events\ProductCreatedEvent;
use App\Jobs\SendProductCreatedEmailJob;
use App\Mail\ProductCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendProductCreatedEmailListener
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
    public function handle(ProductCreatedEvent $event): void
    {

        // $recipient = 'admin@example.com';

        // Mail::to($recipient)->send(new ProductCreated($event->product));

        SendProductCreatedEmailJob::dispatch($event->product);
    }
}
