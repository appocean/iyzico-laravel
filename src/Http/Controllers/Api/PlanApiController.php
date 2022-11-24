<?php

namespace Appocean\Payment\Http\Controllers\Api;

use Appocean\Core\Controller\BaseApiController;
use Appocean\Payment\DTO\Plan\PlanDTO;
use Appocean\Payment\Services\Plan\PlanServiceInterface;

class PlanApiController extends BaseApiController
{
    public function __construct(PlanServiceInterface $service)
    {
        $this->service = $service;
        $this->dtoClass = PlanDTO::class;
    }
}
