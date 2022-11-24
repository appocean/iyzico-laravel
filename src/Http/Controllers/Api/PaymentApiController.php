<?php

namespace Appocean\Payment\Http\Controllers\Api;

use Appocean\Core\Controller\BaseApiController;
use Appocean\Payment\DTO\Payment\PaymentDTO;
use Appocean\Payment\Repositories\Payment\PaymentRepositoryInterface;
use Appocean\Payment\Services\Payment\PaymentServiceInterface;
use Appocean\Payment\Services\Plan\PlanServiceInterface;
use Illuminate\Support\Facades\Auth;

class PaymentApiController extends BaseApiController
{
    /**
     * @var PaymentRepositoryInterface
     */
    private PaymentRepositoryInterface $repository;
    /**
     * @var PlanServiceInterface
     */
    private PlanServiceInterface $planService;

    public function __construct(PaymentRepositoryInterface $repository, PlanServiceInterface $planService)
    {
        //$this->service = $service;
        $this->dtoClass = PaymentDTO::class;
        $this->repository = $repository;
        $this->planService = $planService;
    }

    public function token()
    {

    }

    public function checkUserCanPay()
    {
        $plan_code = request()->get('plan_code');
        $plan_id = null;
        $result = $this->repository->checkUserCanPay(Auth::id());
        if ($result && $plan_code) {
            $plan_id = $this->planService->getPlanIdByPlanCode($plan_code);
        }
        return $this->ok([
            'can_pay' => $result,
            'plan_id' => $plan_id
        ]);
    }
}
