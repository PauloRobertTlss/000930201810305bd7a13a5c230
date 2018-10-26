<?php

namespace Leroy\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class CategoryValidator.
 *
 * @package namespace Leroy\Validators;
 */
class CategoryValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required',
            'description'=> 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required',
            'description'=> 'required'
        ],
    ];
}
