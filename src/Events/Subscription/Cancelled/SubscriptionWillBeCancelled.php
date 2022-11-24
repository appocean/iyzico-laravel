<?php

namespace Appocean\Payment\Events\Subscription\Cancelled;

class SubscriptionWillBeCancelled
{
    /**
     * @var int
     */
    public int $auth_user_id;

    public function __construct(int $auth_user_id)
    {
        $this->auth_user_id = $auth_user_id;
    }
}
