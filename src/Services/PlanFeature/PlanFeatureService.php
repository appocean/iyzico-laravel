<?php

namespace Appocean\Payment\Services\PlanFeature;

use Appocean\Payment\DTO\PlanFeature\PlanFeatureDTO;
use Appocean\Payment\Repositories\PlanFeature\PlanFeatureRepositoryInterface;
use Appocean\Payment\Services\PlanFeature\PlanFeatureServiceInterface;
use Appocean\Core\Services\Base\BaseService;

class PlanFeatureService extends BaseService implements PlanFeatureServiceInterface
{
    /**
     * @var PlanFeatureRepositoryInterface
     */
    private PlanFeatureRepositoryInterface $repository;


    /**
     * PlanFeatureService constructor.
     * @param PlanFeatureRepositoryInterface $repository
     */
    public function __construct(PlanFeatureRepositoryInterface $repository)
    {
        parent::__construct($repository, PlanFeatureDTO::class);
        $this->repository = $repository;
    }
}
