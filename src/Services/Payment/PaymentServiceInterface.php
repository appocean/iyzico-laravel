<?php

namespace Appocean\Payment\Services\Payment;

use Appocean\Core\DTO\Base\BaseDTO;
use Appocean\Payment\Models\Payment;
use Appocean\Core\Services\Base\BaseServiceInterface;
use Appocean\Payment\Models\Plan;
use Appocean\Payment\Models\Product;
use Appocean\Payment\Models\Subscription;

/**
 * Interface PaymentServiceInterface
 * @package Appocean\Payment\Services\Payment\Payment
 */
interface PaymentServiceInterface
{
    public function createProduct(string $name): string;

    public function updateProduct(string $id, string $name): bool;

    public function deleteProduct(string $id): bool;

    public function createPlan(Plan $plan, string $product_id): string;

    public function updatePlan(string $id, Plan $plan): bool;

    public function deletePlan(string $id): bool;

    public function createSubscription(Subscription $subscription): string;

    public function renewSubscription(string $id): bool;

    public function changeSubscription(string $id, string $new_plan_id): bool;

    public function cancelSubscription(string $id): bool;
}
