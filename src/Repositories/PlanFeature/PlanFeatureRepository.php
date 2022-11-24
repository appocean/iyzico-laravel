<?php

namespace Appocean\Payment\Repositories\PlanFeature;

use Appocean\Payment\Models\Plan;
use Appocean\Payment\Models\PlanFeature;
use Appocean\Core\Repositories\Base\BaseEloquentRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class PlanFeatureRepository extends BaseEloquentRepository implements PlanFeatureRepositoryInterface
{
    /**
     * PlanFeatureRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(PlanFeature::class);
    }

    public function allWithFilter($columns, string $orderBy, string $sortBy, array $filters): Collection
    {
        return $this->model::where([
            'plan_id' => $filters['plan_id']
        ])->orderBy($orderBy, $sortBy)->get($columns);
    }

    public function findWithFilter(array $filters)
    {
        return $this->firstOrFail([
            'id' => $filters['feature'],
            'plan_id' => $filters['plan_id'],
        ]);
    }

    public function createWithFilters(array $filters, array $data): Model
    {
        $plan = Plan::findOrFail($filters['plan_id']);
        $plan->features()->saveMany([
            new PlanFeature([
                'name' => $data['name'],
                'value' => $data['value'],
                'sort_order' => $data['sort_order']
            ])
        ]);
        return $plan->features()->latest()->first();
    }
}
