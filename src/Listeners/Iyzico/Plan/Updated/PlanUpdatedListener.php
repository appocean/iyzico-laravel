<?php

namespace Appocean\Payment\Listeners\Iyzico\Plan\Updated;

use Appocean\Payment\Events\Plan\Updated\PlanUpdated;
use Appocean\Payment\Models\PaymentProcessStatus;
use Appocean\Payment\Repositories\Plan\PlanRepositoryInterface;
use Appocean\Payment\Services\IyzicoPayment\IyzicoPaymentServiceInterface;
use Appocean\Payment\Services\Payment\PaymentServiceInterface;
use Illuminate\Support\Facades\Log;

class PlanUpdatedListener
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

    public function handle(PlanUpdated $event)
    {
        $plan = $this->planRepository->find($event->plan_id);

        $result = $this->paymentService->updatePlan($plan->payment_provider_reference_key, $event->plan);

        if ($result) {
            $this->planRepository->setStatus($event->plan_id, PaymentProcessStatus::COMPLETED);
        }
    }
}
