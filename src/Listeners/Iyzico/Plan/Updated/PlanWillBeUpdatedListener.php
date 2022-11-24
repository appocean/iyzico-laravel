<?php

namespace Appocean\Payment\Listeners\Iyzico\Plan\Updated;

use Appocean\Payment\Events\Plan\Updated\PlanWillBeUpdated;
use Illuminate\Support\Facades\Log;

class PlanWillBeUpdatedListener
{
    public function handle(PlanWillBeUpdated $event)
    {
        Log::info('PlanWillBeUpdatedListener called');
    }
}
