<?php

namespace Appocean\Payment\Listeners\Iyzico\Product\Deleted;

use Appocean\Payment\Events\Product\Deleted\ProductDeleted;
use Illuminate\Support\Facades\Log;

class ProductDeletedListener
{
    public function handle(ProductDeleted $event)
    {
        Log::info('ProductDeletedListener called');
    }
}
