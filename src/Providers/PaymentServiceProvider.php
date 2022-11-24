<?php

namespace Appocean\Payment\Providers;

use DigitalCreative\CollapsibleResourceManager\CollapsibleResourceManager;
use DigitalCreative\CollapsibleResourceManager\Resources\TopLevelResource;
use Appocean\Core\Providers\BaseServiceProvider;
use Laravel\Nova\Nova;

class PaymentServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->setModuleName('Payment');
        parent::boot();
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
        parent::register();
    }

    public static function registerNova()
    {
        Nova::resources(
            config('iyzico-laravel.nova_resources')
        );

        Nova::tools([
            new CollapsibleResourceManager([
                'navigation' => [
                    TopLevelResource::make([
                        'label' => __('Payment'),
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="var(--sidebar-icon)" d="M592 64H400L345.37 9.37c-6-6-14.14-9.37-22.63-9.37H176c-26.51 0-48 21.49-48 48v80H48c-26.51 0-48 21.49-48 48v288c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48v-80h80c26.51 0 48-21.49 48-48V112c0-26.51-21.49-48-48-48zM464 464H48V176h80v160c0 26.51 21.49 48 48 48h288v80zm128-128H176V48h140.12l54.63 54.63c6 6 14.14 9.37 22.63 9.37H592v224z"/></svg>',
                        'linkTo' => config('iyzico-laravel.nova_resources')[0],
                        'resources' => config('iyzico-laravel.nova_resources'),
                    ]),
                ],
            ]),
        ]);
    }
}
