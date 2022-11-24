<?php

namespace Appocean\Payment\Events\Product\Updated;

class ProductUpdated
{
    /**
     * @var int
     */
    public int $auth_user_id;

    /**
     * @var int
     */
    public int $product_id;

    /**
     * @var array
     */
    public array $product;

    public function __construct(int $auth_user_id, int $product_id, array $product)
    {
        $this->auth_user_id = $auth_user_id;
        $this->product_id = $product_id;
        $this->product = $product;
    }
}
