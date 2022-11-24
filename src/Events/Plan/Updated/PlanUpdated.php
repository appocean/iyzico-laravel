<?php

namespace Appocean\Payment\Events\Plan\Updated;

use Appocean\Payment\Models\Plan;

class PlanUpdated
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
     * @var Plan
     */
    public Plan $plan;

    public function __construct(int $auth_user_id, int $plan_id, Plan $plan)
    {
        $this->auth_user_id = $auth_user_id;
        $this->plan_id = $plan_id;
        $this->plan = $plan;
    }
}
