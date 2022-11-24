<?php

namespace Appocean\Payment\Http\Controllers\Api;

use Appocean\Core\Controller\BaseApiController;
use Appocean\Payment\DTO\PlanFeature\PlanFeatureDTO;
use Appocean\Payment\Services\PlanFeature\PlanFeatureServiceInterface;

class PlanFeatureApiController extends BaseApiController
{
    public function __construct(PlanFeatureServiceInterface $service)
    {
        $this->service = $service;
        $this->dtoClass = PlanFeatureDTO::class;
        $this->useCustomFilter = true;
    }
}
