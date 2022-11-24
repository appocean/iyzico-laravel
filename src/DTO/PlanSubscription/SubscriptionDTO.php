<?php

namespace Appocean\Payment\DTO\PlanSubscription;

use Appocean\Core\DTO\Base\BaseDTO;
use Appocean\Payment\DTO\Product\ProductDTO;

/**
 * Class SubscriptionDTO
 */
class SubscriptionDTO extends BaseDTO
{
    /**
     * SubscriptionDTO constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        parent::__construct($parameters, self::class);
    }

    /**
     * @var int
     */
    public int $id;

    /**
     * @var array
     */
    public ProductDTO $product;

    /**
     * @var array
     */
    public array $plan_subscription;

    /**
     * @param $dto
     * @param array $originalData
     * @return SubscriptionDTO
     */
    public function mapToDTO($dto, array $originalData): self
    {
        //you can make a change for each field on
        return $dto;
    }

    /**
     * @param array $parameters
     * @param bool $updateMode
     * @return array
     */
    public function validate(array $parameters, bool $updateMode)
    {
        return $this->validator($parameters, [
        ]);
    }

    public function handleRequestParameters(array $requestParameters, array $routeParameters, int $auth_user_id): BaseDTO
    {
        return $this;
    }
}
