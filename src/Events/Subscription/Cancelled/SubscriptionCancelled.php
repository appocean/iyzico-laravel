<?php

namespace Appocean\Payment\Events\Subscription\Cancelled;

class SubscriptionCancelled
{
    /**
     * @var int
     */
    public int $auth_user_id;

    /**
     * @var int
     */
    public int $subscription_id;

    /**
     * @var string
     */
    public ?string $payment_provider_reference_key;

    public function __construct(int $auth_user_id, int $subscription_id, string $payment_provider_reference_key)
    {
        $this->auth_user_id = $auth_user_id;
        $this->subscription_id = $subscription_id;
        $this->payment_provider_reference_key = $payment_provider_reference_key;
    }
}
