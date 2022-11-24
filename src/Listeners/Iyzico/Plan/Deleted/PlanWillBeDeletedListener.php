<?php

namespace Appocean\Payment\Listeners\Iyzico\Plan\Deleted;

use Appocean\Payment\Events\Plan\Deleted\PlanWillBeDeleted;
use Appocean\Payment\Models\PaymentProcessStatus;
use Appocean\Payment\Repositories\Plan\PlanRepositoryInterface;
use Appocean\Payment\Services\IyzicoPayment\IyzicoPaymentServiceInterface;
use Appocean\Payment\Services\Payment\PaymentServiceInterface;
use Illuminate\Support\Facades\Log;

class PlanWillBeDeletedListener
{
    /**
     * @var IyzicoPaymentServiceInterface
     */
    private IyzicoPaymentServiceInterface $paymentService;

    /**
     * @var PlanRepositoryInterface
     */
    private PlanRepositoryInterface $planRepository;

    /**
     * PlanCreatedListener constructor.
     * @param PaymentServiceInterface $paymentService
     * @param PlanRepositoryInterface $planRepository
     */
    public function __construct(PaymentServiceInterface $paymentService, PlanRepositoryInterface $planRepository)
    {
        $this->paymentService = $paymentService;
        $this->planRepository = $planRepository;
    }

    public function handle(PlanWillBeDeleted $event)
    {
        $plan = $this->planRepository->find($event->plan_id);
        $result = $this->paymentService->deletePlan($plan->payment_provider_reference_key);
        if ($result) {
            $this->planRepository->setStatus($event->plan_id, PaymentProcessStatus::COMPLETED);
        }
    }
}
