<?php

namespace Appocean\Payment\Models;

class Plan extends \Rinvex\Subscriptions\Models\Plan
{
    const INTERVAL_FOR_HOUR = 'hour';
    const INTERVAL_FOR_DAY = 'day';
    const INTERVAL_FOR_WEEK = 'week';
    const INTERVAL_FOR_MONTH = 'month';
    const INTERVAL_FOR_YEAR = 'year';

    const INTERVALS = [
        self::INTERVAL_FOR_HOUR,
        self::INTERVAL_FOR_DAY,
        self::INTERVAL_FOR_WEEK,
        self::INTERVAL_FOR_MONTH,
        self::INTERVAL_FOR_YEAR
    ];

    const INTERVALS_FOR = [
        self::INTERVAL_FOR_HOUR => self::INTERVAL_FOR_HOUR,
        self::INTERVAL_FOR_DAY => self::INTERVAL_FOR_DAY,
        self::INTERVAL_FOR_WEEK => self::INTERVAL_FOR_WEEK,
        self::INTERVAL_FOR_MONTH => self::INTERVAL_FOR_MONTH,
        self::INTERVAL_FOR_YEAR => self::INTERVAL_FOR_YEAR
    ];


    public function __construct($attributes = [])
    {
        $this->fillable[] = 'product_id';
        $this->fillable[] = 'payment_provider_reference_key';
        $this->fillable[] = 'status';
        $this->fillable[] = 'code';
        parent::__construct($attributes);
        $this->setRules([]);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
