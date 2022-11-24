<?php

namespace Appocean\Payment\DTO\PlanFeature;

use Appocean\Core\DTO\Base\BaseDTO;
use Appocean\Payment\Models\Plan;
use Illuminate\Validation\Rule;

/**
 * Class PlanFeatureDTO
 */
class PlanFeatureDTO extends BaseDTO
{
    /**
     * PlanFeatureDTO constructor.
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
     * @var string
     */
    public string $value;

    /**
     * @var int
     */
    public ?int $sort_order;

    /**
     * @param $dto
     * @param array $originalData
     * @return PlanFeatureDTO
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
            'name' => 'required|string|strip_tags|max:150',
            'value' => 'required|string',
            'sort_order' => 'required|integer|max:10000',
        ]);
    }

    public function handleRequestParameters(array $requestParameters, array $routeParameters, int $auth_user_id): BaseDTO
    {
        $this->plan_id = $routeParameters['plan_id'];
        return $this;
    }
}
