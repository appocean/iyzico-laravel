<?php

namespace Appocean\Payment\Listeners\Iyzico\Product\Created;

use Appocean\Payment\Events\Product\Created\ProductWillBeCreated;
use Illuminate\Support\Facades\Log;

class ProductWillBeCreatedListener
{
    public function handle(ProductWillBeCreated $event)
    {
        Log::info('ProductWillBeCreatedListener called');
    }
}
