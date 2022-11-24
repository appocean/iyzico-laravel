<?php

namespace Appocean\Payment\Listeners\Iyzico\Subscription\Cancelled;

use Appocean\Payment\Events\Subscription\Cancelled\SubscriptionWillBeCancelled;
use Illuminate\Support\Facades\Log;

class SubscriptionWillBeCancelledListener
{
    public function handle(SubscriptionWillBeCancelled $event)
    {
        Log::info('SubscriptionWillBeCancelledListener called');
    }
}
