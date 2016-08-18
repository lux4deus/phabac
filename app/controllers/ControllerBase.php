<?php
namespace Vokuro\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

use Watchdog\Entities\User;
use Watchdog\Entities\Environment;

/**
 * ControllerBase
 * This is the base controller for all controllers in the application
 */
class ControllerBase extends Controller
{
	use \Watchdog\Traits\ControllerTrait;
	
	/**
	 * @var ABACManager;
	 */
	protected $ABAC;
	
    /**
     * Execute before the router so we can determine if this is a private controller, and must be authenticated, or a
     * public controller that is open to all.
     *
     * @param Dispatcher $dispatcher
     * @return boolean
     */
    public function beforeExecuteRoute(Dispatcher $di)
    {
        $env = new Environment();//$di->getControllerName();
        
        $env->_namespace = $this->acl->namespaceNormalize($di->getNamespaceName());
        $env->_controller = $di->getControllerName();
        $env->_action = $di->getActionName();
        
        $env->day = "16";
        $env->ip = "blah";
        
        $user = ($identity = $this->auth->getIdentity()) && $identity ? Users::findFirst($identity['id']) : new User();
        
        try {
			$policies = (array)$this->calculateRight(); //we can add any common policies to this array
			
			if ($this->watchdog->checkAccess($policies, $env, $user) === false) throw new \Exception("Access denied");
		} catch (\Exception $e) {
			//if ($this->_identity) $this->response->redirect($this->config->application->page_403)->send();
            //else $this->response->redirect($this->config->application->login_page)->send();
            
            return $this->accessDenied();
		}
    }
    
    /**
     * Warning: this method should return ONLY array of Policy objects
     * @return []Policy
     */
    protected function calculateRights() {
		return [];
	}
}
