<?php

namespace Watchdog\Traits;

trait ControllerTrait
{
	/**
	 * This method should do something before returning to requested method
	 */
	protected function accessGranted()
	{
		echo "access granted";
	}
	
	/**
	 * This method should do something if access is denied
	 */
	protected function accessDenied()
	{
		die("Access denied");
	}
}
