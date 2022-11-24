<?php

namespace Appocean\Payment\Events\Plan\Updated;

class PlanWillBeUpdated
{
    /**
     * @var int
     */
    public int $auth_user_id;

    /**
     * @var int
     */
    public int $plan_id;

    /**
     * @var array
     */
    public array $plan;

    public function __construct(int $auth_user_id, int $plan_id, array $plan)
    {
        $this->auth_user_id = $auth_user_id;
        $this->plan_id = $plan_id;
        $this->plan = $plan;
    }
}
