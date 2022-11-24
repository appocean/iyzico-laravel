<?php

namespace Appocean\Payment\Models;

use Illuminate\Support\Facades\DB;

class PlanSubscription extends \Rinvex\Subscriptions\Models\PlanSubscription
{
    protected $with = ['plan'];

    public function __construct($attributes = [])
    {
        $this->fillable[] = 'payment_provider_reference_key';
        $this->fillable[] = 'status';
        parent::__construct($attributes);
    }

    public function renew()
    {
        /*this section copy from base model*/
        if ($this->ended() && $this->canceled()) {
            throw new LogicException('Unable to renew canceled ended subscription.');
        }

        $subscription = $this;

        DB::transaction(function () use ($subscription) {
            // Clear usage data
            $subscription->usage()->delete();

            // Renew period
            $subscription->setNewPeriod();
            $subscription->canceled_at = null;

            //Custom side for Appocean
            $trialDays = $subscription->trial_ends_at->diffInDays(now());
            $subscription->trial_ends_at = $subscription->starts_at;
            $subscription->ends_at = $subscription->ends_at->addDays($trialDays);

            $subscription->save();
        });

        return $this;
    }
}
