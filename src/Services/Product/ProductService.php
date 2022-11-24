<?php

namespace Appocean\Payment\Services\Product;

use Appocean\Payment\DTO\Product\ProductDTO;
use Appocean\Payment\Repositories\Product\ProductRepositoryInterface;
use Appocean\Payment\Services\Product\ProductServiceInterface;
use Appocean\Core\Services\Base\BaseService;

class ProductService extends BaseService implements ProductServiceInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private ProductRepositoryInterface $repository;


    /**
     * ProductService constructor.
     * @param ProductRepositoryInterface $repository
     */
    public function __construct(ProductRepositoryInterface $repository)
    {
        parent::__construct($repository, ProductDTO::class);
        $this->repository = $repository;
    }
}
