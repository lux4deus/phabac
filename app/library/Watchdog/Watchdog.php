<?php

namespace Watchdog;

use Phalcon\Mvc\User\Component;

use Watchdog\Services\ABACManager;
use Watchdog\Services\Request;

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
	
	public function checkAccess($policies, $env, $user)
	{
		return ABACManager::create((array)$policies)->validate(new Request($user, $env));
	}
}
