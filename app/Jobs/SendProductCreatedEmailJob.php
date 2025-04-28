<?php

namespace App\Jobs;

use App\Mail\ProductCreated;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendProductCreatedEmailJob implements ShouldQueue
{
    use Queueable;

    protected $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $recipient = "syeed.sharek510@gmail.com";

        Mail::to($recipient)->send(new ProductCreated($this->product));
    }
}
