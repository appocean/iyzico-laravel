<?php

namespace Appocean\Payment\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Rinvex\Subscriptions\Models\Plan;
use Rinvex\Subscriptions\Models\PlanSubscription;
use Rinvex\Subscriptions\Services\Period;

trait HasSubscriptions
{
    use \Rinvex\Subscriptions\Traits\HasSubscriptions;

    public function getSubscriptionStatusAttribute()
    {
        $result = "not_active";
        $subscriptionOfUser = $this->subscriptionsOfUser->first();

        if (empty($subscriptionOfUser)) {
            return $result;
        }

        if ($subscriptionOfUser->active()) {
            $result = "active";
        }

        if ($subscriptionOfUser->canceled()) {
            $result = "canceled";
        }

        if ($subscriptionOfUser->ended()) {
            $result = "ended";
        }

        return $result;
    }

    public function getIsTrialAttribute()
    {
        $subscriptionOfUser = $this->subscriptionsOfUser->first();
        if (!empty($subscriptionOfUser) && $subscriptionOfUser->onTrial()) {
            return true;
        }
        return false;
    }

    public function newTrial($subscription, Plan $plan, Carbon $trial_ends_at = null): PlanSubscription
    {
        $trial = new Period($plan->trial_interval, $plan->trial_period, now());
        $date = $trial->getEndDate();
        if (!empty($trial_ends_at)) {
            $date = $trial_ends_at;
        }
        return $this->subscriptions()->create([
            'name' => $subscription,
            'plan_id' => $plan->getKey(),
            'trial_ends_at' => $date,
            'starts_at' => $date,
            'ends_at' => $date,
        ]);
    }

    public function subscriptionsOfUser(): MorphMany
    {
        return $this->morphMany(\Appocean\Payment\Models\PlanSubscription::class, 'user');
    }
}
