<?php

namespace Appocean\Payment\Repositories\Product;

use Appocean\Payment\Events\Product\Created\ProductCreated;
use Appocean\Payment\Events\Product\Created\ProductWillBeCreated;
use Appocean\Payment\Events\Product\Deleted\ProductDeleted;
use Appocean\Payment\Events\Product\Deleted\ProductWillBeDeleted;
use Appocean\Payment\Events\Product\Updated\ProductUpdated;
use Appocean\Payment\Events\Product\Updated\ProductWillBeUpdated;
use Appocean\Payment\Models\PaymentProcessStatus;
use Appocean\Payment\Models\Product;
use Appocean\Core\Repositories\Base\BaseEloquentRepository;
use Illuminate\Database\Eloquent\Model;

class ProductRepository extends BaseEloquentRepository implements ProductRepositoryInterface
{
    /**
     * PlanRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(Product::class);
    }

    public function create(array $attributes): Model
    {
        $attributes['status'] = PaymentProcessStatus::PENDING;
        event(new ProductWillBeCreated($this->auth_user_id, $attributes));
        $result = parent::create($attributes);
        event(new ProductCreated($this->auth_user_id, $result->id));
        return $result;
    }

    public function update(int $id, array $data): bool
    {
        $data['status'] = PaymentProcessStatus::PENDING;
        event(new ProductWillBeUpdated($this->auth_user_id, $id, $data));
        $result = parent::update($id, $data);
        event(new ProductUpdated($this->auth_user_id, $id, $data));
        return $result;
    }

    public function delete(int $id): bool
    {
        $product = $this->find($id);
        $product->status = PaymentProcessStatus::PENDING;
        $product->save();

        event(new ProductWillBeDeleted($this->auth_user_id, $id));
        $result = parent::delete($id);
        event(new ProductDeleted($this->auth_user_id, $id));
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function updatePaymentProviderReferenceKey(int $product_id, string $provider_reference_key): bool
    {
        $product = $this->find($product_id);
        $product->payment_provider_reference_key = $provider_reference_key;
        $product->save();
        return true;
    }

    /**
     * @inheritDoc
     */
    public function setStatus(int $product_id, string $status): bool
    {
        $product = $this->find($product_id);
        $product->status = $status;
        $product->save();
        return true;
    }
}
