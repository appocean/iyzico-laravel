<?php

namespace Appocean\Payment\Services\Payment;

use Appocean\Payment\DTO\Payment\PaymentDTO;
use Appocean\Payment\Repositories\Payment\PaymentRepositoryInterface;
use Appocean\Payment\Services\Payment\PaymentServiceInterface;
use Appocean\Core\Services\Base\BaseService;

class PaymentService extends BaseService
{
    /**
     * @var PaymentRepositoryInterface
     */
    private PaymentRepositoryInterface $repository;


    /**
     * PaymentService constructor.
     * @param PaymentRepositoryInterface $repository
     */
    public function __construct(PaymentRepositoryInterface $repository)
    {
        parent::__construct($repository, PaymentDTO::class);
        $this->repository = $repository;
    }
}
