<?php

namespace Appocean\Payment\Events\Product\Created;

class ProductCreated
{
    /**
     * @var int
     */
    public int $auth_user_id;

    /**
     * @var int
     */
    public int $product_id;

    public function __construct(int $auth_user_id, int $product_id)
    {
        $this->auth_user_id = $auth_user_id;
        $this->product_id = $product_id;
    }
}
