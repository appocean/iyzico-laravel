<?php

namespace Appocean\Payment\Listeners\Iyzico\Subscription\Activated;

use Appocean\Payment\Events\Subscription\Activated\SubscriptionActivated;
use Appocean\Payment\Models\PaymentProcessStatus;
use Appocean\Payment\Models\Subscription;
use Appocean\Payment\Repositories\PlanSubscription\PlanSubscriptionRepositoryInterface;
use Appocean\Payment\Services\IyzicoPayment\IyzicoPaymentServiceInterface;
use Appocean\Payment\Services\Payment\PaymentServiceInterface;
use Appocean\Payment\Services\PlanSubscription\PlanSubscriptionServiceInterface;
use Illuminate\Support\Facades\Log;

class SubscriptionActivatedListener
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

    public function handle(SubscriptionActivated $event)
    {
        $subscription = new Subscription();
        $subscription->plan_reference_code = $event->plan_payment_provider_reference_key;
        $subscription->first_name = $event->user['firstname'];
        $subscription->last_name = $event->user['lastname'];
        $subscription->gsm_number = $event->user['gsm_number'];
        $subscription->email = $event->user['email'];
        $subscription->identity_number = $event->user['identity_number'];
        $subscription->city_name = $event->user['city_name'];
        $subscription->country_name = $event->user['country_name'];
        $subscription->address = $event->user['address'];
        $subscription->zip_code = $event->user['zip_code'];
        $subscription->card_holder_name = $event->data['card_holder_name'];
        $subscription->card_number = $event->data['card_number'];
        $subscription->expire_month = $event->data['expire_month'];
        $subscription->expire_year = $event->data['expire_year'];
        $subscription->cvc = $event->data['cvc'];

        $productReferenceCode = $this->paymentService->createSubscription($subscription);
        if (!empty($productReferenceCode)) {
            $this->subscriptionRepository->setStatus($event->subscription_id, PaymentProcessStatus::COMPLETED);
            $this->subscriptionRepository->updatePaymentProviderReferenceKey($event->subscription_id, $productReferenceCode);
        }
    }
}
