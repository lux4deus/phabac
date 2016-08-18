<?php

namespace Watchdog\Entities;

use Watchdog\Services\Request;
use Watchdog\Entities\Operators\Operator;

class Condition implements \Watchdog\Contracts\Validatable
{
	/**
	 * @var Operator
	 */
    protected $operator;
    
    protected $left;
    
    protected $right;
    
    public function __construct($left, Operator $operator, $right)
    {
        $this->left     = $left;
        $this->operator = $operator;
        $this->right    = $right;
    }
    
    public function validate(Request $request)
    {
        $leftValue  = $request->getValue($this->left);
        $rightValue = $request->getValue($this->right);
       
        return $this->operator->execute($leftValue, $rightValue);
    }
}
