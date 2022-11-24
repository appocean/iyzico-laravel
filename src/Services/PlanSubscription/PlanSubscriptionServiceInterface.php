<?php

namespace Appocean\Payment\Services\PlanSubscription;

use Carbon\Carbon;
use Appocean\Core\DTO\Base\BaseDTO;
use Appocean\Payment\DTO\PlanSubscription\PlanSubscriptionDTO;
use Appocean\Payment\Models\PlanSubscription;
use Appocean\Core\Services\Base\BaseServiceInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface PlanSubscriptionServiceInterface
 * @package Appocean\PlanSubscription\Services\PlanSubscription\PlanSubscription
 */
interface PlanSubscriptionServiceInterface extends BaseServiceInterface
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

    /**Create a subscription
     * @param array $filters
     * @param array $data
     * @return bool
     */
    public function createSubscriptionWithoutPaymentProvider(array $filters, array $data): PlanSubscriptionDTO;

    /**Create a trial subscription for user and specific plan
     * @param int $plan_id
     * @param Carbon|null $trial_ends_at
     * @return Model
     */
    public function createTrialSubscription(int $plan_id, Carbon $trial_ends_at = null): Model;

    /**Get user's subscriptions according to plans
     * @param int $user_id
     * @return array
     */
    public function getSubscriptionPlansBy(int $user_id) : array;

    /**Cancel subscription plan without iyzico-laravel provider
     * @return bool
     */
    public function cancelWithoutPaymentProvider(): bool;
}
