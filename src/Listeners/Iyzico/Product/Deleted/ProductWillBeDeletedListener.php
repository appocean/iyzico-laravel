<?php

namespace Appocean\Payment\Listeners\Iyzico\Product\Deleted;

use Appocean\Payment\Events\Product\Deleted\ProductDeleted;
use Appocean\Payment\Events\Product\Deleted\ProductWillBeDeleted;
use Appocean\Payment\Models\PaymentProcessStatus;
use Appocean\Payment\Repositories\Product\ProductRepositoryInterface;
use Appocean\Payment\Services\IyzicoPayment\IyzicoPaymentServiceInterface;
use Appocean\Payment\Services\Payment\PaymentServiceInterface;

class ProductWillBeDeletedListener
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

    public function handle(ProductWillBeDeleted $event)
    {
        $product = $this->productRepository->find($event->product_id);
        $result = $this->paymentService->deleteProduct($product->payment_provider_reference_key);
        if ($result) {
            $this->productRepository->setStatus($event->product_id, PaymentProcessStatus::COMPLETED);
        }
    }
}
