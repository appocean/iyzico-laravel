<?php

namespace Appocean\Payment\Listeners\Iyzico\Subscription\Changed;

use Appocean\Payment\Events\Subscription\Changed\SubscriptionChanged;
use Appocean\Payment\Models\PaymentProcessStatus;
use Appocean\Payment\Repositories\PlanSubscription\PlanSubscriptionRepositoryInterface;
use Appocean\Payment\Services\IyzicoPayment\IyzicoPaymentServiceInterface;
use Appocean\Payment\Services\Payment\PaymentServiceInterface;
use Illuminate\Support\Facades\Log;

class SubscriptionChangedListener
{
    /**
     * @var IyzicoPaymentServiceInterface
     */
    private IyzicoPaymentServiceInterface $paymentService;
    /**
     * @var PlanSubscriptionRepositoryInterface
     */
    private PlanSubscriptionRepositoryInterface $subscriptionRepository;


    /**
     * SubscriptionActivatedListener constructor.
     * @param PaymentServiceInterface $paymentService
     * @param PlanSubscriptionRepositoryInterface $subscriptionRepository
     */
    public function __construct(PaymentServiceInterface $paymentService, PlanSubscriptionRepositoryInterface $subscriptionRepository)
    {
        $this->paymentService = $paymentService;
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function handle(SubscriptionChanged $event)
    {
        $result = $this->paymentService->changeSubscription($event->payment_provider_reference_key, $event->new_plan_id);
        if ($result) {
            $this->subscriptionRepository->setStatus($event->subscription_id, PaymentProcessStatus::COMPLETED);
        }
    }
}
