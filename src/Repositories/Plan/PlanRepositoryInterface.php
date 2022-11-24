<?php

namespace Appocean\Payment\Repositories\Plan;

use Appocean\Payment\Models\Plan;
use Appocean\Core\Repositories\Base\BaseRepositoryInterface;

interface PlanRepositoryInterface extends BaseRepositoryInterface
{
    /**It updates iyzico-laravel provider key
     * @param int $plan_id
     * @param string $provider_reference_key
     * @return bool
     */
    public function updatePaymentProviderReferenceKey(int $plan_id, string $provider_reference_key): bool;

    /**It updates status
     * @param int $plan_id
     * @param string $status
     * @return bool
     */
    public function setStatus(int $plan_id, string $status): bool;

    /**Get plan id according to plan code
     * @param string $code
     * @return int
     */
    public function getPlanIdByPlanCode(string $code): int;
}
