<?php

namespace Appocean\Payment\Events\Plan\Created;

class PlanCreated
{
    /**
     * @var int
     */
    public int $auth_user_id;

    /**
     * @var int
     */
    public int $plan_id;

    public function __construct(int $auth_user_id, int $plan_id)
    {
        $this->auth_user_id = $auth_user_id;
        $this->plan_id = $plan_id;
    }
}
