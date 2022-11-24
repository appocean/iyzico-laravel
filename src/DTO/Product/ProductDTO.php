<?php

namespace Appocean\Payment\DTO\Product;

use Appocean\Core\DTO\Base\BaseDTO;
use Appocean\Payment\Models\Product;
use Illuminate\Validation\Rule;

/**
 * Class ProductDTO
 */
class ProductDTO extends BaseDTO
{
    /**
     * ProductDTO constructor.
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
    public ?string $payment_provider_reference_key;


    /**
     * @param $dto
     * @param array $originalData
     * @return ProductDTO
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
            'name' => 'required|string|unique:products,name|max:150'
        ]);
    }
}
