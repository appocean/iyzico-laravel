<?php

namespace Appocean\Payment\Listeners\Stripe\Product\Created;

use Appocean\Payment\Events\Product\Created\ProductCreated;
use Illuminate\Support\Facades\Log;

class ProductCreatedListener
{
    public function handle(ProductCreated $event)
    {
        Log::info('ProductCreatedListener called');
    }
}
