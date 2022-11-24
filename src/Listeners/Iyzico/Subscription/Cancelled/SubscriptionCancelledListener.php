<?php

namespace Appocean\Payment\Listeners\Iyzico\Subscription\Cancelled;


use Appocean\Payment\Events\Subscription\Cancelled\SubscriptionCancelled;
use Appocean\Payment\Models\PaymentProcessStatus;
use Appocean\Payment\Repositories\PlanSubscription\PlanSubscriptionRepositoryInterface;
use Appocean\Payment\Services\IyzicoPayment\IyzicoPaymentServiceInterface;
use Appocean\Payment\Services\Payment\PaymentServiceInterface;
use Illuminate\Support\Facades\Log;

class SubscriptionCancelledListener
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

    public function handle(SubscriptionCancelled $event)
    {
        $result = $this->paymentService->cancelSubscription($event->payment_provider_reference_key);
        if ($result) {
            $this->subscriptionRepository->setStatus($event->subscription_id, PaymentProcessStatus::COMPLETED);
        }
    }
}
