<?php

namespace Appocean\Payment\Repositories\Product;

use Appocean\Payment\Models\Product;
use Appocean\Core\Repositories\Base\BaseRepositoryInterface;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    /**It updates iyzico-laravel provider key
     * @param int $product_id
     * @param string $provider_reference_key
     * @return bool
     */
    public function updatePaymentProviderReferenceKey(int $product_id, string $provider_reference_key): bool;

    /**It updates status
     * @param int $product_id
     * @param string $status
     * @return bool
     */
    public function setStatus(int $product_id, string $status): bool;
}
