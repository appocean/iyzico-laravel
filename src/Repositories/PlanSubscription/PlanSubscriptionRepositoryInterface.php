<?php

namespace Appocean\Payment\Repositories\PlanSubscription;

use Carbon\Carbon;
use Appocean\Payment\Models\PlanSubscription;
use Appocean\Core\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface PlanSubscriptionRepositoryInterface extends BaseRepositoryInterface
{
    /**Change subscription plan
     * @param int $plan_id
     * @param int $subscription_id
     * @return bool
     */
    public function changePlan(int $subscription_id, int $plan_id): bool;

    /**Check if the user's subscription has ended the trial
     * @return bool
     */
    public function checkByEndedTrial(): bool;

    /**Check if the user's subscription has ended the period
     * @return bool
     */
    public function checkByEndedPeriod(): bool;

    /**It updates iyzico-laravel provider key
     * @param int $subscription_id
     * @param string $provider_reference_key
     * @return bool
     */
    public function updatePaymentProviderReferenceKey(int $subscription_id, string $provider_reference_key): bool;

    /**It updates status
     * @param int $subscription_id
     * @param string $status
     * @return bool
     */
    public function setStatus(int $subscription_id, string $status): bool;

    /**Create a subscription
     * @param array $filters
     * @param array $data
     * @param bool $fireEvents
     * @return Model
     */
    public function createSubscription(array $filters, array $data, bool $fireEvents = true): Model;

    /**Create a trial subscription for user and specific plan
     * @param int $plan_id
     * @param Carbon|null $trial_ends_at
     * @return Model
     */
    public function createTrialSubscription(int $plan_id, Carbon $trial_ends_at = null): Model;

    /**Cancel subscription plan without iyzico-laravel provider
     * @return bool
     */
    public function cancelWithoutPaymentProvider(): bool;
}
