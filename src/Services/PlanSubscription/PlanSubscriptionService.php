<?php

namespace Appocean\Payment\Services\PlanSubscription;

use Carbon\Carbon;
use Appocean\Core\DTO\Base\BaseDTO;
use Appocean\Payment\DTO\PlanSubscription\PlanSubscriptionDTO;
use Appocean\Payment\Repositories\PlanSubscription\PlanSubscriptionRepositoryInterface;
use Appocean\Payment\Services\PlanSubscription\PlanSubscriptionServiceInterface;
use Appocean\Core\Services\Base\BaseService;
use Illuminate\Database\Eloquent\Model;

class PlanSubscriptionService extends BaseService implements PlanSubscriptionServiceInterface
{
    /**
     * @var PlanSubscriptionRepositoryInterface
     */
    private PlanSubscriptionRepositoryInterface $repository;


    /**
     * PlanSubscriptionService constructor.
     * @param PlanSubscriptionRepositoryInterface $repository
     */
    public function __construct(PlanSubscriptionRepositoryInterface $repository)
    {
        parent::__construct($repository, PlanSubscriptionDTO::class);
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    public function changePlan(int $subscription_id, int $plan_id): bool
    {
        return $this->repository->changePlan($subscription_id, $plan_id);
    }

    /**
     * @inheritDoc
     */
    public function checkByEndedTrial(): bool
    {
        return $this->repository->checkByEndedTrial();
    }

    /**
     * @inheritDoc
     */
    public function checkByEndedPeriod(): bool
    {
        return $this->repository->checkByEndedPeriod();
    }

    /**
     * @inheritDoc
     */
    public function createSubscriptionWithoutPaymentProvider(array $filters, array $data): PlanSubscriptionDTO
    {
        $result = $this->repository->createSubscription($filters, $data, false);
        return new PlanSubscriptionDTO($result->toArray());
    }

    /**
     * @inheritDoc
     */
    public function createTrialSubscription(int $plan_id, Carbon $trial_ends_at = null): Model
    {
        return $this->repository->createTrialSubscription($plan_id, $trial_ends_at);
    }

    /**
     * @inheritDoc
     */
    public function getSubscriptionPlansBy(int $user_id): array
    {
        return $this->repository->where('user_id', $user_id)->toListDTO(PlanSubscriptionDTO::class);
    }

    /**
     * @inheritDoc
     */
    public function cancelWithoutPaymentProvider(): bool
    {
        return $this->repository->cancelWithoutPaymentProvider();
    }
}
