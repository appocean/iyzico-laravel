<?php

namespace Appocean\Payment\Events\Plan\Created;

class PlanWillBeCreated
{
    /**
     * @var int
     */
    public int $auth_user_id;

    /**
     * @var array
     */
    public array $plan;


    public function __construct(int $auth_user_id, array $plan)
    {
        $this->auth_user_id = $auth_user_id;
        $this->plan = $plan;
    }
}
