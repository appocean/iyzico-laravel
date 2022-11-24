<?php

namespace Appocean\Payment\Services\Plan;

use Appocean\Payment\DTO\Plan\PlanDTO;
use Appocean\Payment\Repositories\Plan\PlanRepositoryInterface;
use Appocean\Payment\Services\Plan\PlanServiceInterface;
use Appocean\Core\Services\Base\BaseService;

class PlanService extends BaseService implements PlanServiceInterface
{
    /**
     * @var PlanRepositoryInterface
     */
    private PlanRepositoryInterface $repository;


    /**
     * PlanService constructor.
     * @param PlanRepositoryInterface $repository
     */
    public function __construct(PlanRepositoryInterface $repository)
    {
        parent::__construct($repository, PlanDTO::class);
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    public function getPlanIdByPlanCode(string $code): int
    {
        return $this->repository->getPlanIdByPlanCode($code);
    }
}
