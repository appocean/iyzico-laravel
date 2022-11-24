<?php

namespace Appocean\Payment\Listeners\Iyzico\Product\Updated;

use Appocean\Payment\Events\Product\Updated\ProductUpdated;
use Appocean\Payment\Models\PaymentProcessStatus;
use Appocean\Payment\Repositories\Product\ProductRepositoryInterface;
use Appocean\Payment\Services\IyzicoPayment\IyzicoPaymentServiceInterface;
use Appocean\Payment\Services\Payment\PaymentServiceInterface;
use Illuminate\Support\Facades\Log;

class ProductUpdatedListener
{
    /**
     * @var IyzicoPaymentServiceInterface
     */
    private IyzicoPaymentServiceInterface $paymentService;

    /**
     * @var ProductRepositoryInterface
     */
    private ProductRepositoryInterface $productRepository;

    /**
     * ProductCreatedListener constructor.
     * @param PaymentServiceInterface $paymentService
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(PaymentServiceInterface $paymentService, ProductRepositoryInterface $productRepository)
    {
        $this->paymentService = $paymentService;
        $this->productRepository = $productRepository;
    }

    public function handle(ProductUpdated $event)
    {
        $product = $this->productRepository->find($event->product_id);
        $payment_provider_reference_key = $product->payment_provider_reference_key;
        $new_product_name = $event->product['name'];
        $result = $this->paymentService->updateProduct($payment_provider_reference_key, $new_product_name);
        if ($result) {
            $this->productRepository->setStatus($event->product_id, PaymentProcessStatus::COMPLETED);
        }
    }
}
