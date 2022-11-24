<?php

namespace Appocean\Payment\Listeners\Iyzico\Product\Created;

use Appocean\Payment\Events\Product\Created\ProductCreated;
use Appocean\Payment\Models\PaymentProcessStatus;
use Appocean\Payment\Repositories\Product\ProductRepositoryInterface;
use Appocean\Payment\Services\IyzicoPayment\IyzicoPaymentServiceInterface;
use Appocean\Payment\Services\Payment\PaymentServiceInterface;
use Illuminate\Support\Facades\Log;

class ProductCreatedListener
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

    public function handle(ProductCreated $event)
    {
        $product = $this->productRepository->find($event->product_id);
        $productReferenceCode = $this->paymentService->createProduct($product->name);
        if (!empty($productReferenceCode)) {
            $this->productRepository->setStatus($event->product_id, PaymentProcessStatus::COMPLETED);
            $this->productRepository->updatePaymentProviderReferenceKey($event->product_id, $productReferenceCode);
        }
    }
}
