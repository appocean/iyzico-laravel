<?php

namespace Appocean\Payment\Http\Controllers\Api;

use Appocean\Core\Controller\BaseApiController;
use Appocean\Payment\DTO\Product\ProductDTO;
use Appocean\Payment\Services\Product\ProductServiceInterface;

class ProductApiController extends BaseApiController
{
    public function __construct(ProductServiceInterface $service)
    {
        $this->service = $service;
        $this->dtoClass = ProductDTO::class;
    }
}
