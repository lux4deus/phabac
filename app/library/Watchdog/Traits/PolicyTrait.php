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
    
    public function readPolicy($id)
    {
        return (isset($this->policies[$id])) ? $this->policies[$id] : false;
    }
    
    public function updatePolicy($id, Policy $policy)
    {
		if (isset($this->policies[$id]) && $this->policies[$id] instanceof Policy) {
			$this->policies[$id] = $policy;
			
			return true;
		}
		
		return false;
	}
	
	public function createPolicy($responseType, $name, $description, array $rules)
	{
		$policy = new Policy((string)$responseType, (string)$name, (string)$description, $rules);
		$this->policies[] = $policy;
		
		return $policy;
	}
	
	public function deletePolicy($id)
	{
		return (isset($this->policies[(int)$id])) ? array_splice($this->policies, (int)$id, 1) : false;
	}
}
