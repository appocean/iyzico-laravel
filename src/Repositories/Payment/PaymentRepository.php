<?php

namespace Appocean\Payment\Repositories\Payment;

use Appocean\Payment\Models\Payment;
use Appocean\Core\Repositories\Base\BaseEloquentRepository;

class PaymentRepository extends BaseEloquentRepository implements PaymentRepositoryInterface
{
    /**
     * PaymentRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(Payment::class);
    }

    /**
     * @inheritDoc
     */
    public function checkUserCanPay(int $user_id) : bool
    {
        $userModel = config('iyzico-laravel.models.user');
        $user = $userModel::find($user_id);

        return !(empty($user->gsm_number) ||
            empty($user->identity_number) ||
            empty($user->city_name) ||
            empty($user->country_name) ||
            empty($user->address) ||
            empty($user->zip_code));
    }
}
