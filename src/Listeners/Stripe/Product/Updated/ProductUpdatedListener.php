<?php

namespace Appocean\Payment\Listeners\Stripe\Product\Updated;

use Appocean\Payment\Events\Product\Updated\ProductUpdated;
use Illuminate\Support\Facades\Log;

class ProductUpdatedListener
{
    public function handle(ProductUpdated $event)
    {
        Log::info('ProductUpdatedListener called');
    }
}
