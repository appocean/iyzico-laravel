<?php

namespace Appocean\Payment\Listeners\Iyzico\Plan\Created;

use Appocean\Payment\Events\Plan\Created\PlanWillBeCreated;
use Illuminate\Support\Facades\Log;

class PlanWillBeCreatedListener
{
    public function handle(PlanWillBeCreated $event)
    {
        Log::info('PlanWillBeCreatedListener called');
    }
}
