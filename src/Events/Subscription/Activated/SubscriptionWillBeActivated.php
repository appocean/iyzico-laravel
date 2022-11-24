<?php

namespace Appocean\Payment\Events\Subscription\Activated;

class SubscriptionWillBeActivated
{
    /**
     * @var int
     */
    public int $auth_user_id;

    /**
     * @var array
     */
    public array $user;

    public function __construct(int $auth_user_id, array $user)
    {
        $this->auth_user_id = $auth_user_id;
        $this->user = $user;
    }
}
