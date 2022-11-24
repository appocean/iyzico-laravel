<?php

namespace Appocean\Payment\Listeners\Iyzico\Subscription\Renewed;

use Appocean\Payment\Events\Subscription\Renewed\SubscriptionRenewed;
use Illuminate\Support\Facades\Log;

class SubscriptionRenewedListener
{
    public function handle(SubscriptionRenewed $event)
    {
        Log::info('SubscriptionRenewedListener called');
    }
}
