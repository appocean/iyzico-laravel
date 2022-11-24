<?php

namespace Appocean\Payment\Services\Plan;

use Appocean\Payment\Models\Plan;
use Appocean\Core\Services\Base\BaseServiceInterface;

/**
 * Interface PlanServiceInterface
 * @package Appocean\Plan\Services\Plan\Plan
 */
interface PlanServiceInterface extends BaseServiceInterface
{
    /**Get plan id according to plan code
     * @param string $code
     * @return int
     */
    public function getPlanIdByPlanCode(string $code): int;
}
