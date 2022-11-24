<?php

namespace Appocean\Payment\DTO\PlanSubscription;

use Appocean\Core\DTO\Base\BaseDTO;

/**
 * Class PlanSubscriptionDTO
 */
class PlanSubscriptionDTO extends BaseDTO
{
    /**
     * PlanSubscriptionDTO constructor.
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
     * @var int
     */
    public int $plan_id;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var array
     */
    public array $plan;

    /**
     * @var string
     */
    public string $trial_ends_at;

    /**
     * @var string
     */
    public string $starts_at;

    /**
     * @var string
     */
    public string $ends_at;

    /**
     * @var string
     */
    public ?string $cancels_at;

    /**
     * @var string
     */
    public ?string $canceled_at;

    /**
     * @var string
     */
    public string $card_holder_name;

    /**
     * @var string
     */
    public string $card_number;

    /**
     * @var int
     */
    public int $expire_month;

    /**
     * @var int
     */
    public int $expire_year;

    /**
     * @var int
     */
    public int $cvc;

    /**
     * @param $dto
     * @param array $originalData
     * @return PlanSubscriptionDTO
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
            'card_holder_name' => 'required|string',
            'card_number' => 'required|string',
            'expire_month' => 'required|int',
            'expire_year' => 'required|int',
            'cvc' => 'required|int',
        ]);
    }

    public function handleRequestParameters(array $requestParameters, array $routeParameters, int $auth_user_id): BaseDTO
    {
        $this->plan_id = $routeParameters['plan_id'];
        return $this;
    }
}
