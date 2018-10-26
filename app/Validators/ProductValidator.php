<?php

namespace Leroy\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class ProductValidator.
 *
 * @package namespace Leroy\Validators;
 */
class ProductValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required',
            'price'  => 'required',
            'description'=> 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required',
            'price'  => 'required',
            'description'=> 'required'
        ],
    ];
}
