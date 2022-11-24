<?php

namespace Appocean\Payment\Nova;

use App\Nova\User;
use Benjaminhirsch\NovaSlugField\Slug;
use Benjaminhirsch\NovaSlugField\TextWithSlug;
use Appocean\Payment\Models\PlanSubscription as PlanSubscriptionModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasManyThrough;
use Laravel\Nova\Fields\HasOneThrough;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Timezone;
use Laravel\Nova\Resource;
use Spatie\NovaTranslatable\Translatable;

class PlanSubscription extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = PlanSubscriptionModel::class;

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
        'id',
    ];

    public function authorizedToDelete(Request $request)
    {
        return false;
    }

    public static function authorizedToCreate(Request $request)
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
            MorphTo::make('User')->types([
                User::class
            ])->hideWhenUpdating()->readonly(),
            BelongsTo::make(__('Plan'), 'plan', Plan::class)->readonly(),
            HasOneThrough::make('Product', 'product', Product::class),
            DateTime::make(__('Trial Ends At'), 'trial_ends_at'),
            DateTime::make(__('Starts At'), 'starts_at'),
            DateTime::make(__('Ends At'), 'ends_at'),
            DateTime::make(__('Cancels At'), 'cancels_at'),
            DateTime::make(__('Canceled At'), 'canceled_at'),
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
