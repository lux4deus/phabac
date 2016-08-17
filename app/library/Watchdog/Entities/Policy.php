<?php

namespace Watchdog\Entities;

use InvalidArgumentException;
use Illuminate\Support\Collection;
use Watchdog\Services\Request;
use Watchdog\Traits\DescriptionTrait;

class Policy implements \Watchdog\Contracts\Validatable
{
    use DescriptionTrait;
    
    const ACCEPT    = 'ACCEPT';
    const DENY      = 'DENY';
    
    protected $responseType;
    
    protected $rules;
    
    public function __construct($responseType, $name, $description, array $rules)
    {
        if(!in_array($responseType, [static::ACCEPT, static::DENY]))
			throw new InvalidArgumentException("Response type must be 'ACCEPT' or 'DENY.");
			
        $this->responseType = $responseType;
        $this->name = $name;
        $this->description = $description;
        $this->rules = new Collection($rules);
    }
    
    public static function create($responseType, $name, $description, array $rules)
    {
        return new static($responseType, $name, $description, $rules);
    }
    
    public function getResponseType()
    {
        return $this->responseType;
    }
    
    public function validate(Request $request)
    {
        return ! $this->rules->reject(function($rule) use ($request){
            return $rule->validate($request);
        })->count();
    }
}
