<?php

namespace Appocean\Payment\Services\IyzicoPayment;

use Appocean\Payment\Models\Plan;
use Appocean\Payment\Models\Subscription;
use Appocean\Payment\Services\Payment\PaymentServiceInterface;
use Illuminate\Support\Facades\Crypt;
use Iyzipay\IyzipayResource;
use Iyzipay\Model\Customer;
use Iyzipay\Model\Locale;
use Iyzipay\Model\PaymentCard;
use Iyzipay\Model\Status;
use Iyzipay\Model\Subscription\SubscriptionCancel;
use Iyzipay\Model\Subscription\SubscriptionCreate;
use Iyzipay\Model\Subscription\SubscriptionPricingPlan;
use Iyzipay\Model\Subscription\SubscriptionProduct;
use Iyzipay\Model\Subscription\SubscriptionUpgrade;
use Iyzipay\Options;
use Iyzipay\Request\Subscription\SubscriptionCancelRequest;
use Iyzipay\Request\Subscription\SubscriptionCreatePricingPlanRequest;
use Iyzipay\Request\Subscription\SubscriptionCreateProductRequest;
use Iyzipay\Request\Subscription\SubscriptionCreateRequest;
use Iyzipay\Request\Subscription\SubscriptionDeletePricingPlanRequest;
use Iyzipay\Request\Subscription\SubscriptionDeleteProductRequest;
use Iyzipay\Request\Subscription\SubscriptionUpdatePricingPlanRequest;
use Iyzipay\Request\Subscription\SubscriptionUpdateProductRequest;
use Iyzipay\Request\Subscription\SubscriptionUpgradeRequest;

class IyzicoPaymentService implements IyzicoPaymentServiceInterface
{
    private string $locale = Locale::TR;
    private string $conversation_id;

    public function createProduct(string $name): string
    {
        $this->conversation_id = $this->getConversationId();
        $request = new SubscriptionCreateProductRequest();
        $request->setLocale($this->locale);
        $request->setConversationId($this->conversation_id);
        $request->setName($name);
        $result = SubscriptionProduct::create($request, $this->options());

        if ($this->isSuccess($result)) {
            return $result->getReferenceCode();
        } else {
            throw new \Exception($result->getErrorMessage());
        }
    }

    public function updateProduct(string $id, string $name): bool
    {
        $this->conversation_id = $this->getConversationId();
        $request = new SubscriptionUpdateProductRequest();
        $request->setLocale($this->locale);
        $request->setConversationId($this->conversation_id);
        $request->setProductReferenceCode($id);
        $request->setName($name);
        $result = SubscriptionProduct::update($request, $this->options());
        if ($this->isSuccess($result)) {
            return true;
        } else {
            throw new \Exception($result->getErrorMessage());
        }
        return false;
    }

    public function deleteProduct(string $id): bool
    {
        $this->conversation_id = $this->getConversationId();
        $request = new SubscriptionDeleteProductRequest();
        $request->setLocale($this->locale);
        $request->setConversationId($this->conversation_id);
        $request->setProductReferenceCode($id);

        $result = SubscriptionProduct::delete($request, $this->options());
        if ($this->isSuccess($result)) {
            return true;
        } else {
            throw new \Exception($result->getErrorMessage());
        }
        return false;
    }

    public function createPlan(Plan $plan, string $product_id): string
    {
        $this->conversation_id = $this->getConversationId();
        $request = new SubscriptionCreatePricingPlanRequest();
        $request->setLocale($this->locale);
        $request->setConversationId($this->conversation_id);
        $request->setProductReferenceCode($product_id);
        $request->setName($plan->name);
        $request->setPrice($plan->price);
        $request->setCurrencyCode($plan->currency);
        $request->setPaymentInterval($this->planIntervalMapper($plan->invoice_interval));
        $request->setPaymentIntervalCount($plan->invoice_period);
        $request->setPlanPaymentType('RECURRING');
        if (config('iyzico-laravel.sync_trial_day_with_the_payment_provider')) {
            $request->setTrialPeriodDays($plan->trial_period);
        }
        $result = SubscriptionPricingPlan::create($request, $this->options());
        if ($this->isSuccess($result)) {
            return $result->getReferenceCode();
        } else {
            throw new \Exception($result->getErrorMessage());
        }
    }

    public function updatePlan(string $id, Plan $plan): bool
    {
        $this->conversation_id = $this->getConversationId();
        $request = new SubscriptionUpdatePricingPlanRequest();
        $request->setLocale($this->locale);
        $request->setConversationId($this->conversation_id);
        $request->setPricingPlanReferenceCode($id);
        $request->setName($plan->name);
        $request->setTrialPeriodDays($plan->trial_period);
        $result = SubscriptionPricingPlan::update($request, $this->options());
        if ($this->isSuccess($result)) {
            return true;
        } else {
            throw new \Exception($result->getErrorMessage());
        }
        return false;
    }

    public function deletePlan(string $id): bool
    {
        $this->conversation_id = $this->getConversationId();
        $request = new SubscriptionDeletePricingPlanRequest();
        $request->setPricingPlanReferenceCode($id);
        $request->setLocale($this->locale);
        $request->setConversationId($this->conversation_id);
        $result = SubscriptionPricingPlan::delete($request, $this->options());
        if ($this->isSuccess($result)) {
            return true;
        } else {
            throw new \Exception($result->getErrorMessage());
        }
        return false;
    }

    public function createSubscription(Subscription $subscription): string
    {
        $this->conversation_id = $this->getConversationId();
        $request = new SubscriptionCreateRequest();
        $request->setLocale($this->locale);
        $request->setConversationId($this->conversation_id);
        $request->setPricingPlanReferenceCode($subscription->plan_reference_code);
        $request->setSubscriptionInitialStatus("ACTIVE");

        $paymentCard = new PaymentCard();
        $paymentCard->setCardHolderName($subscription->card_holder_name);
        $paymentCard->setCardNumber($subscription->card_number);
        $paymentCard->setExpireMonth($subscription->expire_month);
        $paymentCard->setExpireYear($subscription->expire_year);
        $paymentCard->setCvc($subscription->cvc);
        $paymentCard->setRegisterConsumerCard(true);
        $request->setPaymentCard($paymentCard);

        $customer = new Customer();
        $contact_name = $subscription->first_name . ' ' . $subscription->last_name;
        $customer->setName($subscription->first_name);
        $customer->setSurname($subscription->last_name);
        $customer->setGsmNumber($subscription->gsm_number);
        $customer->setEmail($subscription->email);

        $customer->setIdentityNumber($subscription->identity_number);
        $customer->setShippingContactName($contact_name);
        $customer->setShippingCity($subscription->city_name);
        $customer->setShippingCountry($subscription->country_name);
        $customer->setShippingAddress($subscription->address);
        $customer->setShippingZipCode($subscription->zip_code);

        $customer->setBillingContactName($contact_name);
        $customer->setBillingCity($subscription->city_name);
        $customer->setBillingCountry($subscription->country_name);
        $customer->setBillingAddress($subscription->address);
        $customer->setBillingZipCode($subscription->zip_code);

        $request->setCustomer($customer);
        $result = SubscriptionCreate::create($request, $this->options());

        if ($this->isSuccess($result)) {
            return $result->getReferenceCode();
        } else {
            throw new \Exception($result->getErrorMessage());
        }
    }

    public function renewSubscription(string $id): bool
    {
        // TODO: Implement renewSubscription() method.
    }

    public function changeSubscription(string $id, string $new_plan_id): bool
    {
        $this->conversation_id = $this->getConversationId();
        $request = new SubscriptionUpgradeRequest();
        $request->setLocale($this->locale);
        $request->setConversationId($this->conversation_id);
        $request->setSubscriptionReferenceCode($id);
        $request->setNewPricingPlanReferenceCode($new_plan_id);
        $request->setUpgradePeriod("NOW");
        //$request->setUseTrial(true);
        $request->setResetRecurrenceCount(true);
        $result = SubscriptionUpgrade::update($request, $this->options());
        if ($this->isSuccess($result)) {
            return true;
        } else {
            throw new \Exception($result->getErrorMessage());
        }
        return false;
    }

    public function cancelSubscription(string $id): bool
    {
        $this->conversation_id = $this->getConversationId();
        $request = new SubscriptionCancelRequest();
        $request->setLocale($this->locale);
        $request->setConversationId($this->conversation_id);
        $request->setSubscriptionReferenceCode($id);
        $result = SubscriptionCancel::cancel($request, $this->options());
        if ($this->isSuccess($result)) {
            return true;
        } else {
            throw new \Exception($result->getErrorMessage());
        }
        return false;
    }

    function options(): Options
    {
        $options = new Options();

        $api_key = config('iyzico-laravel.api-key');
        $secret_key = config('iyzico-laravel.secret-key');

        if (empty($api_key) || empty($secret_key)) {
            throw new \Exception("You should specify iyzico_api_key in your env file.");
        }
        $options->setApiKey(config('iyzico-laravel.api-key'));
        $options->setSecretKey(config('iyzico-laravel.secret-key'));
        $options->setBaseUrl(config('iyzico-laravel.base-url'));
        return $options;
    }

    function getConversationId(): string
    {
        return Crypt::encryptString(now());
    }

    function isSuccess(IyzipayResource $result): bool
    {
        if (!empty($result) && $result->getStatus() == Status::SUCCESS /*&& $result->getConversationId() == $this->conversation_id*/) {
            return true;
        }
        return false;
    }

    function planIntervalMapper(string $interval): string
    {
        switch ($interval) {
            case 'hour':
                return 'HOURLY';
            case 'day':
                return 'DAILY';
            case 'week':
                return 'WEEKLY';
            case 'month':
                return 'MONTHLY';
            case 'year':
                return 'YEARLY';
        }
    }
}
