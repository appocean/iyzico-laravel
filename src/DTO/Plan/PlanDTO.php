<?php

namespace Appocean\Payment\DTO\Plan;

use Appocean\Core\DTO\Base\BaseDTO;
use Appocean\Payment\Models\Plan;
use Illuminate\Validation\Rule;

/**
 * Class PlanDTO
 */
class PlanDTO extends BaseDTO
{
    /**
     * PlanDTO constructor.
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
     * @var string
     */
    public string $name;

    /**
     * @var string
     */
    public ?string $description;

    /**
     * @var string
     */
    public string $slug;

    /**
     * @var float
     */
    public float $price;

    /**
     * @var string
     */
    public string $currency;

    /**
     * @var string
     */
    public string $trial_interval;

    /**
     * @var string
     */
    public string $trial_period;

    /**
     * @var int
     */
    public int $invoice_period;

    /**
     * @var string
     */
    public string $invoice_interval;


    /**
     * @var int
     */
    public ?int $sort_order;

    /**
     * @var bool
     */
    public bool $is_active;

    /**
     * @var float
     */
    public float $signup_fee;


    /**
     * @var int
     */
    public int $product_id;


    /**
     * @param $dto
     * @param array $originalData
     * @return PlanDTO
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
            'slug' => 'required|alpha_dash|max:150|unique:plans,slug',
            'name' => 'required|string|strip_tags|max:150',
            'description' => 'nullable|string|max:10000',
            'price' => 'required|numeric',
            'product_id' => 'required|int|exists:products,id',
            'currency' => 'required|alpha|size:3',
            'trial_interval' => [
                'required', Rule::in(Plan::INTERVALS)
            ],
            'trial_period' => 'required|integer|max:10000',
            'invoice_interval' => [
                'required', Rule::in(Plan::INTERVALS)
            ],
            'invoice_period' => 'required|integer|max:10000',
            'sort_order' => 'nullable|integer|max:10000',
            'signup_fee' => 'required|numeric',
        ]);
    }
}
