<?php

namespace Appocean\Payment\Repositories\Plan;

use Appocean\Payment\Events\Plan\Created\PlanCreated;
use Appocean\Payment\Events\Plan\Created\PlanWillBeCreated;
use Appocean\Payment\Events\Plan\Deleted\PlanDeleted;
use Appocean\Payment\Events\Plan\Deleted\PlanWillBeDeleted;
use Appocean\Payment\Events\Plan\Updated\PlanUpdated;
use Appocean\Payment\Events\Plan\Updated\PlanWillBeUpdated;
use Appocean\Payment\Models\PaymentProcessStatus;
use Appocean\Payment\Models\Plan;
use Appocean\Core\Repositories\Base\BaseEloquentRepository;
use Illuminate\Database\Eloquent\Model;

class PlanRepository extends BaseEloquentRepository implements PlanRepositoryInterface
{
    /**
     * PlanRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(Plan::class);
    }

    public function create(array $attributes): Model
    {
        $attributes['status'] = PaymentProcessStatus::PENDING;
        event(new PlanWillBeCreated($this->auth_user_id, $attributes));
        $result = parent::create($attributes);
        event(new PlanCreated($this->auth_user_id, $result->id));
        return $result;
    }

    public function update(int $id, array $data): bool
    {
        $data['status'] = PaymentProcessStatus::PENDING;
        event(new PlanWillBeUpdated($this->auth_user_id, $id, $data));
        $result = parent::update($id, $data);
        event(new PlanUpdated($this->auth_user_id, $id, $this->find($id)));
        return $result;
    }

    public function delete(int $id): bool
    {
        $plan = $this->find($id);
        $plan->status = PaymentProcessStatus::PENDING;
        $plan->save();

        event(new PlanWillBeDeleted($this->auth_user_id, $id));

        $plan = $this->find($id);
        if ($plan->status == PaymentProcessStatus::COMPLETED) {
            $result = parent::delete($id);
            event(new PlanDeleted($this->auth_user_id, $id));
            return $result;
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function updatePaymentProviderReferenceKey(int $plan_id, string $provider_reference_key): bool
    {
        $plan = $this->find($plan_id);
        $plan->payment_provider_reference_key = $provider_reference_key;
        $plan->save();
        return true;
    }

    /**
     * @inheritDoc
     */
    public function setStatus(int $plan_id, string $status): bool
    {
        $plan = $this->find($plan_id);
        $plan->status = $status;
        $plan->save();
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getPlanIdByPlanCode(string $code): int
    {
        $result = $this->model::where('code', $code)->first();
        if (empty($result)) {
            return 0;
        } else {
            return $result->id;
        }
    }
}
