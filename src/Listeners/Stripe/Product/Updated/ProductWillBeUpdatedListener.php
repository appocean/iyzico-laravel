<?php

namespace Appocean\Payment\Listeners\Stripe\Product\Updated;

use Appocean\Payment\Events\Product\Updated\ProductWillBeUpdated;
use Illuminate\Support\Facades\Log;

class ProductWillBeUpdatedListener
{
    public function handle(ProductWillBeUpdated $event)
    {
        Log::info('ProductWillBeUpdatedListener called');
    }
}
