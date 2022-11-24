<?php

namespace Appocean\Payment\Listeners\Iyzico\Subscription\Changed;

use Appocean\Payment\Events\Subscription\Changed\SubscriptionWillBeChanged;
use Illuminate\Support\Facades\Log;

class SubscriptionWillBeChangedListener
{
    public function handle(SubscriptionWillBeChanged $event)
    {
        Log::info('SubscriptionWillBeChangedListener called');
    }
}
