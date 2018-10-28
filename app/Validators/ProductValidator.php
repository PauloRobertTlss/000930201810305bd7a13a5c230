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
    
    protected $messages = [
        'lm.required' => 'O código único lm* é obrigatório',
        'name.required' => 'O name é obrigatório',
        'description.required' => 'Uma descrição é obrigatório',
        'price.required' => 'O preço é obrigatório',
        'name.min' => 'minímo para name 5 caracteres'
    ];
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'lm' => 'required|unique:products',
            'name' => 'required|min:5',
            'price'  => 'required',
            'description'=> 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
        ],
    ];
}
