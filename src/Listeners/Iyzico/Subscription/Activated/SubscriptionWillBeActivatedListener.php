<?php

namespace Appocean\Payment\Listeners\Iyzico\Subscription\Activated;

use Appocean\Payment\Events\Subscription\Activated\SubscriptionWillBeActivated;
use Appocean\Payment\Models\Subscription;
use Appocean\Payment\Repositories\PlanSubscription\PlanSubscriptionRepositoryInterface;
use Appocean\Payment\Services\IyzicoPayment\IyzicoPaymentServiceInterface;
use Appocean\Payment\Services\Payment\PaymentServiceInterface;
use Appocean\Payment\Services\PlanSubscription\PlanSubscriptionServiceInterface;
use Illuminate\Support\Facades\Log;

class SubscriptionWillBeActivatedListener
{


    public function handle(SubscriptionWillBeActivated $event)
    {

    }
}
