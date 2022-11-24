<?php

namespace Appocean\Payment\Events\Product\Created;

class ProductWillBeCreated
{
    /**
     * @var int
     */
    public int $auth_user_id;

    /**
     * @var array
     */
    public array $product;


    public function __construct(int $auth_user_id, array $product)
    {
        $this->auth_user_id = $auth_user_id;
        $this->product = $product;
    }
}
