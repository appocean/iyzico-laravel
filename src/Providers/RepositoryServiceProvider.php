<?php

namespace Appocean\Payment\Providers;

use Appocean\Payment\Repositories\Payment\PaymentRepository;
use Appocean\Payment\Repositories\Payment\PaymentRepositoryInterface;
use Appocean\Payment\Repositories\Plan\PlanRepository;
use Appocean\Payment\Repositories\Plan\PlanRepositoryInterface;
use Appocean\Payment\Repositories\PlanFeature\PlanFeatureRepository;
use Appocean\Payment\Repositories\PlanFeature\PlanFeatureRepositoryInterface;
use Appocean\Payment\Repositories\PlanSubscription\PlanSubscriptionRepository;
use Appocean\Payment\Repositories\PlanSubscription\PlanSubscriptionRepositoryInterface;
use Appocean\Payment\Repositories\Product\ProductRepository;
use Appocean\Payment\Repositories\Product\ProductRepositoryInterface;
use Appocean\Payment\Services\IyzicoPayment\IyzicoPaymentService;
use Appocean\Payment\Services\IyzicoPayment\IyzicoPaymentServiceInterface;
use Appocean\Payment\Services\Payment\PaymentService;
use Appocean\Payment\Services\Payment\PaymentServiceInterface;
use Appocean\Payment\Services\Plan\PlanService;
use Appocean\Payment\Services\Plan\PlanServiceInterface;
use Appocean\Payment\Services\PlanFeature\PlanFeatureService;
use Appocean\Payment\Services\PlanFeature\PlanFeatureServiceInterface;
use Appocean\Payment\Services\PlanSubscription\PlanSubscriptionService;
use Appocean\Payment\Services\PlanSubscription\PlanSubscriptionServiceInterface;
use Appocean\Payment\Services\Product\ProductService;
use Appocean\Payment\Services\Product\ProductServiceInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //repositories
        $this->app->bind(PaymentRepositoryInterface::class, PaymentRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(PlanRepositoryInterface::class, PlanRepository::class);
        $this->app->bind(PlanFeatureRepositoryInterface::class, PlanFeatureRepository::class);
        $this->app->bind(PlanSubscriptionRepositoryInterface::class, PlanSubscriptionRepository::class);

        //services
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(PlanServiceInterface::class, PlanService::class);
        $this->app->bind(PlanFeatureServiceInterface::class, PlanFeatureService::class);
        $this->app->bind(PlanSubscriptionServiceInterface::class, PlanSubscriptionService::class);

        //singleton
        $this->app->singleton(PaymentServiceInterface::class, IyzicoPaymentService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
