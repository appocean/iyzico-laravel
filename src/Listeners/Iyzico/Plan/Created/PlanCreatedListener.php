<?php

namespace Appocean\Payment\Listeners\Iyzico\Plan\Created;

use Appocean\Payment\Events\Plan\Created\PlanCreated;
use Appocean\Payment\Models\PaymentProcessStatus;
use Appocean\Payment\Models\Plan;
use Appocean\Payment\Repositories\Plan\PlanRepositoryInterface;
use Appocean\Payment\Repositories\Product\ProductRepositoryInterface;
use Appocean\Payment\Services\IyzicoPayment\IyzicoPaymentServiceInterface;
use Appocean\Payment\Services\Payment\PaymentServiceInterface;
use Appocean\Payment\Services\Plan\PlanServiceInterface;
use Illuminate\Support\Facades\Log;

class PlanCreatedListener
{
    /**
     * @var PaymentServiceInterface
     */
    private PaymentServiceInterface $paymentService;

    /**
     * @var PlanRepositoryInterface
     */
    private PlanRepositoryInterface $planRepository;

    /**
     * @var ProductRepositoryInterface
     */
    private ProductRepositoryInterface $productRepository;

    /**
     * PlanCreatedListener constructor.
     * @param PaymentServiceInterface $paymentService
     * @param PlanRepositoryInterface $planRepository
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(PaymentServiceInterface $paymentService, PlanRepositoryInterface $planRepository, ProductRepositoryInterface $productRepository)
    {
        $this->paymentService = $paymentService;
        $this->planRepository = $planRepository;
        $this->productRepository = $productRepository;
    }

    public function handle(PlanCreated $event)
    {
        $plan = $this->planRepository->find($event->plan_id);
        $product = $this->productRepository->find($plan->product_id);
        $product_reference_code = $product->payment_provider_reference_key;
        $planReferenceCode = $this->paymentService->createPlan($plan, $product_reference_code);

        if (!empty($planReferenceCode)) {
            $this->planRepository->setStatus($event->plan_id, PaymentProcessStatus::COMPLETED);
            $this->planRepository->updatePaymentProviderReferenceKey($event->plan_id, $planReferenceCode);
        }
    }
}
