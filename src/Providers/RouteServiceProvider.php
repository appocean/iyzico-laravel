<?php

namespace Appocean\Payment\Providers;

use Appocean\Core\Providers\BaseRouteServiceProvider;

class RouteServiceProvider extends BaseRouteServiceProvider
{
    public function boot()
    {
        $this->setModuleName('Payment');
        parent::boot();
    }
}
