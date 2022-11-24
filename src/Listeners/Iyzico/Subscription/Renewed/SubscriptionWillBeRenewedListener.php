<?php

namespace Appocean\Payment\Listeners\Iyzico\Subscription\Renewed;

use Appocean\Payment\Events\Subscription\Renewed\SubscriptionWillBeRenewed;
use Illuminate\Support\Facades\Log;

class SubscriptionWillBeRenewedListener
{
    public function handle(SubscriptionWillBeRenewed $event)
    {
        Log::info('SubscriptionWillBeRenewedListener called');
    }
}
