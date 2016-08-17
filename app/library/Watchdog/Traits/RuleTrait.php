<?php

namespace Watchdog\Traits;

trait RuleTrait
{
	/**
	 * @var []Rule
	 */
    protected $rules;
    
    public function __construct()
    {
		return $this;
	}
    
    public function readRule($id)
    {
        return (isset($this->rules[$id])) ? $this->rules[$id] : false;
    }
    
    public function updateRule($id, \Watchdog\Entities\Rule $rule)
    {
		if (isset($this->rules[$id]) && $this->rules[$id] instanceof \Watchdog\Entities\Rule) {
			$this->rules[$id] = $rule;
			
			return true;
		}
		
		return false;
	}
	
	public function createRule($name, $description, array $conditions)
	{
		$rule = new \Watchdog\Entities\Rule((string)$name, (string)$description, $conditions);
		$this->rules[] = $rule;
		
		return $rule;
	}
	
	public function deleteRule($id)
	{
		return (isset($this->rules[(int)$id])) ? array_splice($this->rules, (int)$id, 1) : false;
	}
}
