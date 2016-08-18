<?php

namespace Watchdog;

use Phalcon\Config\Adapter\Yaml as ymlProvider;
use Phalcon\Mvc\User\Component;

use Watchdog\Traits\RuleTrait;
use Watchdog\Traits\ConditionTrait;
use Watchdog\Traits\PolicyTrait;

class Watchdog extends Component
{	
	use RuleTrait {
		RuleTrait::__construct as private __rconstruct;
	}
	
	use ConditionTrait {
		ConditionTrait::__construct as private __cconstruct;
	}
	
	use PolicyTrait {
		PolicyTrait::__construct as private __pconstruct;
	}
	
	public function __construct()
	{
		$this->__cconstruct();
		$this->__rconstruct();
		$this->__pconstruct();
	}
	
	public function checkAccess()
	{
		
	}
	
	private function exportACL()
	{
		
	}
	
	private function importACL()
	{
		
	}
	
	private function exportABAC()
	{
		
	}
	
	private function importABAC()
	{
		
	}
}
