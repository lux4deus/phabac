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
	public $GreaterThanInclusive;
	public $GreaterThan;
	public $Equals;
	public $BetweenInclusive;
	public $Between;
	public $LessThanInclusive;
	public $NotEquals;
	public $LessThan;
	/**
	 * @var []Condition
	 */
    protected $conditions;
    
    public function __construct()
    {
		$this->GreaterThanInclusive = new GreaterThanInclusive();
		$this->GreaterThan = new GreaterThan();
		$this->Equals = new Equals();
		$this->BetweenInclusive = new BetweenInclusive();
		$this->Between = new Between();
		$this->LessThanInclusive = new LessThanInclusive();
		$this->NotEquals = new NotEquals();
		$this->LessThan = new LessThan();
	}
	
    public function readCondition($id)
    {
        return (isset($this->conditions[$id])) ? $this->conditions[$id] : false;
    }
    
    public function updateCondition($id, \Watchdog\Entities\Condition $condition)
    {
		if (isset($this->conditions[$id]) && $this->conditions[$id] instanceof \Watchdog\Entities\Condition) {
			$this->conditions[$id] = $condition;
			
			return true;
		}
		
		return false;
	}
	
	public function createCondition($name, $description, array $conditions)
	{
		$condition = new \Watchdog\Entities\Condition((string)$name, (string)$description, $conditions);
		$this->conditions[] = $condition;
		
		return $condition;
	}
	
	public function deleteCondition($id)
	{
		return (isset($this->conditions[(int)$id])) ? array_splice($this->conditions, (int)$id, 1) : false;
	}
}
