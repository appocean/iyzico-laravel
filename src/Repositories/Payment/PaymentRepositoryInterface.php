<?php

namespace Appocean\Payment\Repositories\Payment;

use Appocean\Payment\Models\Payment;
use Appocean\Core\Repositories\Base\BaseRepositoryInterface;

interface PaymentRepositoryInterface extends BaseRepositoryInterface
{
    /**It checks if user can pay
     * @param int $user_id
     * @return bool
     */
    public function checkUserCanPay(int $user_id) : bool;
}
