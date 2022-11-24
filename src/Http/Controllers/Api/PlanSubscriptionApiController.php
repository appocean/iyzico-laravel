<?php

namespace Appocean\Payment\Http\Controllers\Api;

use Appocean\Core\Controller\BaseApiController;
use Appocean\Payment\DTO\PlanSubscription\PlanSubscriptionDTO;
use Appocean\Payment\DTO\PlanSubscription\SubscriptionDTO;
use Appocean\Payment\Services\PlanSubscription\PlanSubscriptionServiceInterface;
use Appocean\Payment\Services\Product\ProductServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanSubscriptionApiController extends BaseApiController
{
    /**
     * @var ProductServiceInterface
     */
    private ProductServiceInterface $productService;

    public function __construct(PlanSubscriptionServiceInterface $service,
                                ProductServiceInterface $productService)
    {
        $this->service = $service;
        $this->dtoClass = PlanSubscriptionDTO::class;
        $this->useCustomFilter = true;
        $this->productService = $productService;
    }

    public function changePlan(Request $request, int $plan_id, int $subscription_id)
    {
        $new_plan_id = $request->get('new_plan_id');
        if (empty($new_plan_id)) {
            return $this->notValidated([
                "new_plan_id" => ["The new_plan_id field is required."]
            ]);
        }
        $this->service->setAuthUserId($request->user()->id);
        $result = $this->service->changePlan($subscription_id, $new_plan_id);
        return $this->ok($result);
    }

    public function checkByEndedTrial()
    {
        $this->service->setAuthUserId(\request()->user()->id);
        $result = $this->service->checkByEndedTrial();
        return $this->ok($result);
    }

    public function checkByEndedPeriod()
    {
        $this->service->setAuthUserId(\request()->user()->id);
        $result = $this->service->checkByEndedPeriod();
        return $this->ok($result);
    }

    public function subscriptionWithoutPaymentProvider(Request $request)
    {
        $this->service->setAuthUserId($request->user()->id);
        $result = $this->service->createSubscriptionWithoutPaymentProvider($request->route()->parameters, []);
        return $this->ok($result);
    }

    public function subscriptions()
    {
        $subscriptionsDTO = new SubscriptionDTO();
        $subscriptionsDTO->product = $this->productService->first([]);
        $subscriptionsDTO->plan_subscription = $this->service->getSubscriptionPlansBy(Auth::id());
        return $this->ok($subscriptionsDTO);
    }

    public function cancel(Request $request)
    {
        $this->service->setAuthUserId($request->user()->id);
        $result = $this->service->cancelWithoutPaymentProvider();
        return $this->ok($result);
    }
}
