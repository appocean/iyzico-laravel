<?php

namespace Appocean\Payment\Providers;

use Appocean\Payment\Events\Plan\Created\PlanCreated;
use Appocean\Payment\Events\Plan\Created\PlanWillBeCreated;
use Appocean\Payment\Events\Plan\Deleted\PlanDeleted;
use Appocean\Payment\Events\Plan\Deleted\PlanWillBeDeleted;
use Appocean\Payment\Events\Plan\Updated\PlanUpdated;
use Appocean\Payment\Events\Plan\Updated\PlanWillBeUpdated;
use Appocean\Payment\Events\Product\Created\ProductCreated;
use Appocean\Payment\Events\Product\Created\ProductWillBeCreated;
use Appocean\Payment\Events\Product\Deleted\ProductDeleted;
use Appocean\Payment\Events\Product\Deleted\ProductWillBeDeleted;
use Appocean\Payment\Events\Product\Updated\ProductUpdated;
use Appocean\Payment\Events\Product\Updated\ProductWillBeUpdated;
use Appocean\Payment\Events\Subscription\Activated\SubscriptionActivated;
use Appocean\Payment\Events\Subscription\Activated\SubscriptionWillBeActivated;
use Appocean\Payment\Events\Subscription\Cancelled\SubscriptionCancelled;
use Appocean\Payment\Events\Subscription\Cancelled\SubscriptionWillBeCancelled;
use Appocean\Payment\Events\Subscription\Changed\SubscriptionChanged;
use Appocean\Payment\Events\Subscription\Changed\SubscriptionWillBeChanged;
use Appocean\Payment\Events\Subscription\Renewed\SubscriptionRenewed;
use Appocean\Payment\Events\Subscription\Renewed\SubscriptionWillBeRenewed;
use Appocean\Payment\Listeners\Iyzico\Plan\Created\PlanCreatedListener;
use Appocean\Payment\Listeners\Iyzico\Plan\Created\PlanWillBeCreatedListener;
use Appocean\Payment\Listeners\Iyzico\Plan\Deleted\PlanDeletedListener;
use Appocean\Payment\Listeners\Iyzico\Plan\Deleted\PlanWillBeDeletedListener;
use Appocean\Payment\Listeners\Iyzico\Plan\Updated\PlanUpdatedListener;
use Appocean\Payment\Listeners\Iyzico\Plan\Updated\PlanWillBeUpdatedListener;
use Appocean\Payment\Listeners\Iyzico\Product\Created\ProductCreatedListener;
use Appocean\Payment\Listeners\Iyzico\Product\Created\ProductWillBeCreatedListener;
use Appocean\Payment\Listeners\Iyzico\Product\Deleted\ProductDeletedListener;
use Appocean\Payment\Listeners\Iyzico\Product\Deleted\ProductWillBeDeletedListener;
use Appocean\Payment\Listeners\Iyzico\Product\Updated\ProductUpdatedListener;
use Appocean\Payment\Listeners\Iyzico\Product\Updated\ProductWillBeUpdatedListener;
use Appocean\Payment\Listeners\Iyzico\Subscription\Activated\SubscriptionActivatedListener;
use Appocean\Payment\Listeners\Iyzico\Subscription\Activated\SubscriptionWillBeActivatedListener;
use Appocean\Payment\Listeners\Iyzico\Subscription\Cancelled\SubscriptionCancelledListener;
use Appocean\Payment\Listeners\Iyzico\Subscription\Cancelled\SubscriptionWillBeCancelledListener;
use Appocean\Payment\Listeners\Iyzico\Subscription\Changed\SubscriptionChangedListener;
use Appocean\Payment\Listeners\Iyzico\Subscription\Changed\SubscriptionWillBeChangedListener;
use Appocean\Payment\Listeners\Iyzico\Subscription\Renewed\SubscriptionRenewedListener;
use Appocean\Payment\Listeners\Iyzico\Subscription\Renewed\SubscriptionWillBeRenewedListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;


class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ProductWillBeCreated::class => [
            ProductWillBeCreatedListener::class
        ],
        ProductCreated::class => [
            ProductCreatedListener::class
        ],
        ProductWillBeUpdated::class => [
            ProductWillBeUpdatedListener::class
        ],
        ProductUpdated::class => [
            ProductUpdatedListener::class
        ],
        ProductWillBeDeleted::class => [
            ProductWillBeDeletedListener::class
        ],
        ProductDeleted::class => [
            ProductDeletedListener::class
        ],

        PlanWillBeCreated::class => [
            PlanWillBeCreatedListener::class
        ],
        PlanCreated::class => [
            PlanCreatedListener::class
        ],
        PlanWillBeUpdated::class => [
            PlanWillBeUpdatedListener::class
        ],
        PlanUpdated::class => [
            PlanUpdatedListener::class
        ],
        PlanWillBeDeleted::class => [
            PlanWillBeDeletedListener::class
        ],
        PlanDeleted::class => [
            PlanDeletedListener::class
        ],

        SubscriptionWillBeActivated::class => [
            SubscriptionWillBeActivatedListener::class
        ],
        SubscriptionActivated::class => [
            SubscriptionActivatedListener::class
        ],

        SubscriptionWillBeCancelled::class => [
            SubscriptionWillBeCancelledListener::class
        ],
        SubscriptionCancelled::class => [
            SubscriptionCancelledListener::class
        ],

        SubscriptionWillBeChanged::class => [
            SubscriptionWillBeChangedListener::class
        ],
        SubscriptionChanged::class => [
            SubscriptionChangedListener::class
        ],

        SubscriptionWillBeRenewed::class => [
            SubscriptionWillBeRenewedListener::class
        ],
        SubscriptionRenewed::class => [
            SubscriptionRenewedListener::class
        ]
    ];
}
