<?php

namespace Appocean\Payment\Listeners\Iyzico\Plan\Deleted;

use Appocean\Payment\Events\Plan\Deleted\PlanDeleted;
use Illuminate\Support\Facades\Log;

class PlanDeletedListener
{
    public function handle(PlanDeleted $event)
    {
        Log::info('PlanDeletedListener called');
    }
}
