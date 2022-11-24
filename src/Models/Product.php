<?php

namespace Appocean\Payment\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'payment_provider_reference_key',
        'status'
    ];
}
