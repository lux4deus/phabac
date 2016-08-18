<?php

namespace Watchdog\Traits;

use Watchdog\Entities\Operators\GreaterThanInclusive;
use Watchdog\Entities\Operators\GreaterThan;
use Watchdog\Entities\Operators\Equals;
use Watchdog\Entities\Operators\BetweenInclusive;
use Watchdog\Entities\Operators\Between;
use Watchdog\Entities\Operators\LessThanInclusive;
use Watchdog\Entities\Operators\NotEquals;
use Watchdog\Entities\Operators\LessThan;

trait ConditionTrait
{
	/**
	 * @var stdClass
	 */
	public $operator;
	
	/**
	 * @var []Condition
	 */
    protected $conditions;
    
    /**
     * We can using Singleton of each operation
     */
    public function __construct()
    {
		$this->operator = new \stdClass();
		
		$this->operator->greaterThanInclusive = new GreaterThanInclusive();
		$this->operator->greaterThan = new GreaterThan();
		$this->operator->equals = new Equals();
		$this->operator->betweenInclusive = new BetweenInclusive();
		$this->operator->between = new Between();
		$this->operator->lessThanInclusive = new LessThanInclusive();
		$this->operator->notEquals = new NotEquals();
		$this->operator->lessThan = new LessThan();
	}
    
    /**
     * @param integer $id
     * @return Condition object if this one is exist or false
     */
    public function readCondition($id)
    {
        return (isset($this->conditions[$id])) ? $this->conditions[$id] : false;
    }
    
    /**
     * CRUD: Update Condition element
     * @param integer $id
     * @return boolean true if this Condition is exist and was updated or false
     */
    public function updateCondition($id, \Watchdog\Entities\Condition $condition)
    {
		if (isset($this->conditions[$id]) && $this->conditions[$id] instanceof \Watchdog\Entities\Condition) {
			$this->conditions[$id] = $condition;
			
			return true;
		}
		
		return false;
	}
	
	/**
	 * CRUD: Create Condition element
	 * @param string $expression
	 * @param Operation $operation
	 * @param string $description
	 * @return Condition that was created
	 */
	public function createCondition($expression, \Watchdog\Entities\Operators\Operator $operation, $value)
	{
		$condition = new \Watchdog\Entities\Condition($expression, $operation, $value);
		$this->conditions[] = $condition;
		
		return $condition;
	}
	
	/**
	 * CRUD: Delete Condition element
	 * @param integer $id
	 * @return boolean result of deletion or false if this element isn't exist
	 */
	public function deleteCondition($id)
	{
		return (isset($this->conditions[(int)$id])) ? array_splice($this->conditions, (int)$id, 1) : false;
	}
}
