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
        'name.required' => 'O name é obrigatório',
        'description.required' => 'Uma descrição é obrigatório',
        'price.required' => 'O preço é obrigatório',
        'name.min' => 'minímo para name 10 caracteres'
    ];
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required|min:5',
            'price'  => 'required',
            'description'=> 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required|min:10',
            'price'  => 'required',
            'description'=> 'required'
        ],
    ];
}
