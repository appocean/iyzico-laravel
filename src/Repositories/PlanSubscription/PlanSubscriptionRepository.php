<?php

namespace Appocean\Payment\Repositories\PlanSubscription;

use App\Models\User;
use Carbon\Carbon;
use Appocean\Payment\Events\Subscription\Activated\SubscriptionActivated;
use Appocean\Payment\Events\Subscription\Activated\SubscriptionWillBeActivated;
use Appocean\Payment\Events\Subscription\Cancelled\SubscriptionCancelled;
use Appocean\Payment\Events\Subscription\Cancelled\SubscriptionWillBeCancelled;
use Appocean\Payment\Events\Subscription\Changed\SubscriptionChanged;
use Appocean\Payment\Events\Subscription\Changed\SubscriptionWillBeChanged;
use Appocean\Payment\Events\Subscription\Renewed\SubscriptionRenewed;
use Appocean\Payment\Events\Subscription\Renewed\SubscriptionWillBeRenewed;
use Appocean\Payment\Models\PaymentProcessStatus;
use Appocean\Payment\Models\Plan;
use Appocean\Payment\Models\PlanSubscription;
use Appocean\Core\Repositories\Base\BaseEloquentRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class PlanSubscriptionRepository extends BaseEloquentRepository implements PlanSubscriptionRepositoryInterface
{
    /**
     * PlanSubscriptionRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(PlanSubscription::class);
    }

    /**
     * @inheritDoc
     */
    public function allWithFilter($columns, string $orderBy, string $sortBy, array $filters): Collection
    {
        return $this->model::where([
            'plan_id' => $filters['plan_id']
        ])->orderBy($orderBy, $sortBy)->get($columns);
    }

    /**
     * @inheritDoc
     */
    public function findWithFilter(array $filters)
    {
        return $this->firstOrFail([
            'id' => $filters['subscription'],
            'plan_id' => $filters['plan_id'],
        ]);
    }

    /**
     * @inheritDoc
     */
    public function createWithFilters(array $filters, array $data): Model
    {
        return $this->createSubscription($filters, $data, true);
    }

    /**
     * @inheritDoc
     */
    public function updateWithFilters(array $filters, array $data): bool
    {
        $user = User::findOrFail($this->auth_user_id);
        event(new SubscriptionWillBeRenewed($this->auth_user_id, $data));
        $result = $user->subscriptionsOfUser->first()->renew();
        $this->setStatus($result->id, PaymentProcessStatus::PENDING);
        event(new SubscriptionRenewed($this->auth_user_id, $data));
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteWithFilter(array $filters): bool
    {
        return $this->cancelSubscription();
    }

    /**
     * @inheritDoc
     */
    public function changePlan(int $subscription_id, int $plan_id): bool
    {
        $plan = Plan::findOrFail($plan_id);
        $subscription = PlanSubscription::findOrFail($subscription_id);

        event(new SubscriptionWillBeChanged($this->auth_user_id, $subscription_id));
        $subscription->changePlan($plan);
        $this->setStatus($subscription->id, PaymentProcessStatus::PENDING);

        event(new SubscriptionChanged($this->auth_user_id, $subscription_id, $subscription->payment_provider_reference_key, $plan_id));
        return true;
    }

    /**
     * @inheritDoc
     */
    public function checkByEndedTrial(): bool
    {
        $user = User::findOrFail($this->auth_user_id);
        return !$user->subscriptionsOfUser->first()->onTrial();
    }

    /**
     * @inheritDoc
     */
    public function checkByEndedPeriod(): bool
    {
        $user = User::findOrFail($this->auth_user_id);
        return $user->subscriptionsOfUser->first()->ended();
    }

    /**
     * @inheritDoc
     */
    public function updatePaymentProviderReferenceKey(int $subscription_id, string $provider_reference_key): bool
    {
        $subscription = $this->find($subscription_id);
        $subscription->payment_provider_reference_key = $provider_reference_key;
        $subscription->save();
        return true;
    }

    /**
     * @inheritDoc
     */
    public function setStatus(int $subscription_id, string $status): bool
    {
        $subscription = $this->find($subscription_id);
        $subscription->status = $status;
        $subscription->save();
        return true;
    }

    /**
     * @inheritDoc
     */
    public function createSubscription(array $filters, array $data, bool $fireEvents = true): Model
    {
        $plan = Plan::findOrFail($filters['plan_id']);
        $user = User::findOrFail($this->auth_user_id);
        if ($fireEvents) {
            event(new SubscriptionWillBeActivated($this->auth_user_id, $data, $user));
        }

        $subscriptionOfUser = $user->subscriptionsOfUser->first();
        if (!empty($subscriptionOfUser) && ($subscriptionOfUser->ended() || $subscriptionOfUser->onTrial())) {
            $result = $subscriptionOfUser->renew();
        } else {
            $result = $user->newSubscription('main', $plan);
        }

        $this->setStatus($result->id, PaymentProcessStatus::PENDING);
        if ($fireEvents) {
            event(new SubscriptionActivated($this->auth_user_id, $user, $plan->payment_provider_reference_key, $data, $result->id));
        }
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function createTrialSubscription(int $plan_id, Carbon $trial_ends_at = null): Model
    {
        $plan = Plan::findOrFail($plan_id);
        $user = User::findOrFail($this->auth_user_id);
        $result = $user->newTrial('main', $plan, $trial_ends_at);
        $this->setStatus($result->id, PaymentProcessStatus::PENDING);
        return $result;
    }

    /**
     * @param bool $fireEvents
     * @return bool
     */
    protected function cancelSubscription(bool $fireEvents = true){
        $user = User::findOrFail($this->auth_user_id);
        $subscriptionOfUser = $user->subscriptionsOfUser->first();
        event(new SubscriptionWillBeCancelled($this->auth_user_id));
        $result = $subscriptionOfUser->cancel();
        if ($fireEvents) {
            $this->setStatus($result->id, PaymentProcessStatus::PENDING);
            event(new SubscriptionCancelled($this->auth_user_id, $result->id, $subscriptionOfUser->payment_provider_reference_key));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function cancelWithoutPaymentProvider(): bool
    {
        return $this->cancelSubscription(false);
    }
}
