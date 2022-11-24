<?php

namespace Appocean\Payment\Nova;

use Benjaminhirsch\NovaSlugField\Slug;
use Benjaminhirsch\NovaSlugField\TextWithSlug;
use Appocean\Payment\Models\PaymentProcessStatus;
use Appocean\Payment\Models\Plan as PlanModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphOne;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;
use Spatie\NovaTranslatable\Translatable;

class Plan extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = PlanModel::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id'
    ];

    public function authorizedToUpdate(Request $request)
    {
        return false;
    }

    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    public function authorizedToDelete(Request $request)
    {
        return false;
    }


    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Translatable::make([
                TextWithSlug::make(__('Name'), 'name')->rules('required')->slug('slug'),
                Textarea::make(__('Description'), 'description'),
            ]),
            Slug::make(__('Slug'), 'slug'),
            Boolean::make(__('Is Active'), 'is_active'),
            BelongsTo::make(__('Product'), 'product', Product::class),
            Number::make(__('Price'), 'price')->min(1)->step(0.01),
            Number::make(__('Signup Fee'), 'signup_fee')->min(1)->step(0.01),
            Text::make(__('Currency'), 'currency'),
            Number::make(__('Trial Period'), 'trial_period')->hideFromIndex(),
            Select::make(__('Trial Interval'), 'trial_interval')->options(PlanModel::INTERVALS_FOR)->hideFromIndex(),
            Number::make(__('Invoice Period'), 'invoice_period')->hideFromIndex(),
            Select::make(__('Invoice Interval'), 'invoice_interval')->options(PlanModel::INTERVALS_FOR)->hideFromIndex(),
            Number::make(__('Grace Period'), 'grace_period')->hideFromIndex(),
            Select::make(__('Grace Interval'), 'grace_interval')->options(PlanModel::INTERVALS_FOR)->hideFromIndex(),
            Number::make(__('Prorate Day'), 'prorate_day')->hideFromIndex(),
            Number::make(__('Prorate Period'), 'prorate_period')->hideFromIndex(),
            Number::make(__('Prorate Extend Due'), 'prorate_extend_due')->hideFromIndex(),
            Number::make(__('Active Subscribers Limit'), 'active_subscribers_limit')->hideFromIndex(),
            Text::make(__('Payment Provider Reference Key'), 'payment_provider_reference_key')->hideFromIndex(),
            Select::make(__('Status'), 'status')->options(PaymentProcessStatus::STATUSES),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
        ];
    }
}
