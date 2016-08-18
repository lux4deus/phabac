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
    
    /**
     * CRUD: Read Rule element
     * @param integer $id
     * @return boolean false if this one element isn't exist or Rule
     */
    public function readRule($id)
    {
        return (isset($this->rules[$id])) ? $this->rules[$id] : false;
    }
    
    /**
     * CRUD: Update Rule element
     * @param integer $id
     * @param Rule $rule
     * @return boolean true if this Rule is exist and was updated or false
     */
    public function updateRule($id, \Watchdog\Entities\Rule $rule)
    {
		if (isset($this->rules[$id]) && $this->rules[$id] instanceof \Watchdog\Entities\Rule) {
			$this->rules[$id] = $rule;
			
			return true;
		}
		
		return false;
	}
	
	/**
	 * CRUD: Create Rule element
	 * @param string $name
	 * @param string $description
	 * @param array $conditions - []Condition
	 * @return Rule
	 */
	public function createRule($name, $description, array $conditions)
	{
		$rule = new \Watchdog\Entities\Rule((string)$name, (string)$description, $conditions);
		$this->rules[] = $rule;
		
		return $rule;
	}
	
	/**
	 * CRUD: Delete Rule element
	 * @param integer $id
	 * @return boolean result of deletion or false if this element isn't exist
	 */
	public function deleteRule($id)
	{
		return (isset($this->rules[(int)$id])) ? array_splice($this->rules, (int)$id, 1) : false;
	}
}
