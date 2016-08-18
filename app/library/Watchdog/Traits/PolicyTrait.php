<?php

namespace Watchdog\Traits;

use Watchdog\Entities\Policy;

trait PolicyTrait
{
	/**
	 * @var []Policy
	 */
    protected $policies;
    
    public function __construct()
    {
		return $this;
	}
    
    /**
     * @param integer $id
     * @return Policy object if this one is exist or false
     */
    public function readPolicy($id)
    {
        return (isset($this->policies[$id])) ? $this->policies[$id] : false;
    }
    
    /**
     * CRUD: Update Policy element
     * @param integer $id
     * @return boolean true if Policy is exist and was updated or false
     */
    public function updatePolicy($id, Policy $policy)
    {
		if (isset($this->policies[$id]) && $this->policies[$id] instanceof Policy) {
			$this->policies[$id] = $policy;
			
			return true;
		}
		
		return false;
	}
	
	/**
	 * CRUD: Create Policy element
	 * @param string $responseType - ACCEPT or DENY
	 * @param string $name
	 * @param string $description
	 * @param array $rules - []Rule
	 * @return Policy that was created
	 */
	public function createPolicy($responseType, $name, $description, array $rules)
	{
		$policy = new Policy((string)$responseType, (string)$name, (string)$description, $rules);
		$this->policies[] = $policy;
		
		return $policy;
	}
	
	/**
	 * CRUD: Delete Policy element
	 * @param integer $id
	 * @return boolean result of deletion or false if this element isn't exist
	 */
	public function deletePolicy($id)
	{
		return (isset($this->policies[(int)$id])) ? array_splice($this->policies, (int)$id, 1) : false;
	}
}
