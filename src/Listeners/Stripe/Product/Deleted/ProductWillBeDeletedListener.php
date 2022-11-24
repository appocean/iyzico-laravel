<?php

namespace Appocean\Payment\Listeners\Stripe\Product\Deleted;

use Appocean\Payment\Events\Product\Deleted\ProductWillBeDeleted;
use Illuminate\Support\Facades\Log;

class ProductWillBeDeletedListener
{
    public function handle(ProductWillBeDeleted $event)
    {
        Log::info('ProductWillBeDeletedListener called');
    }
}
