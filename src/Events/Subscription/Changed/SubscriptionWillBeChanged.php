<?php

namespace Appocean\Payment\Events\Subscription\Changed;

class SubscriptionWillBeChanged
{
    /**
     * @var int
     */
    public int $auth_user_id;

    /**
     * @var int
     */
    public int $subscription_id;

    public function __construct(int $auth_user_id, int $subscription_id)
    {
        $this->auth_user_id = $auth_user_id;
        $this->subscription_id = $subscription_id;
    }
}
