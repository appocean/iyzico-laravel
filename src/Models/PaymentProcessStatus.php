<?php

namespace Appocean\Payment\Models;

class PaymentProcessStatus
{
    const PENDING = 'pending';
    const COMPLETED = 'completed';

    const STATUSES = [
        self::PENDING => self::PENDING,
        self::COMPLETED => self::COMPLETED
    ];
}
