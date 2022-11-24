<?php

namespace Appocean\Payment\Events\Subscription\Activated;

use App\Models\User;
class SubscriptionActivated
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
     * @var User
     */
    public User $user;

    /**
     * @var string
     */
    public string $plan_payment_provider_reference_key;

    /**
     * @var array
     */
    public array $data;

    public function __construct(int $auth_user_id, User $user, string $plan_payment_provider_reference_key, array $data, int $subscription_id)
    {
        $this->auth_user_id = $auth_user_id;
        $this->user = $user;
        $this->plan_payment_provider_reference_key = $plan_payment_provider_reference_key;
        $this->data = $data;
        $this->subscription_id = $subscription_id;
    }
}
