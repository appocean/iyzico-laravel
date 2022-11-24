<?php

namespace Appocean\Payment\Events\Subscription\Renewed;

class SubscriptionWillBeRenewed
{
    /**
     * @var int
     */
    public int $auth_user_id;

    /**
     * @var array
     */
    private array $data;

    public function __construct(int $auth_user_id, array $data)
    {
        $this->auth_user_id = $auth_user_id;
        $this->data = $data;
    }
}
