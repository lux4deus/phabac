<?php
namespace Vokuro\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

use Ultimate\Acl\Models\Users;
use Watchdog\Entities\User;
use Watchdog\Entities\Environment;

/**
 * ControllerBase
 * This is the base controller for all controllers in the application
 */
class ControllerBase extends Controller
{	
	use \Watchdog\Traits\ControllerTrait;
	use \Watchdog\Traits\RBACRoleTrait;
	
	//binary RBAC
	//owners CRUD
	const OWNER_CAN_CREATE = 1;
	const OWNER_CAN_READ = 2;
	const OWNER_CAN_UPDATE = 4;
	const OWNER_CAN_DELETE = 8;
	
	//group CRUD
	const GROUP_CAN_CREATE = 16;
	const GROUP_CAN_READ = 32;
	const GROUP_CAN_UPDATE = 64;
	const GROUP_CAN_DELETE = 128;
	
	//others CRUD
	const OTHERS_CAN_CREATE = 256;
	const OTHERS_CAN_READ = 512;
	const OTHERS_CAN_UPDATE = 1024;
	const OTHERS_CAN_DELETE = 2048;
	
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
        $this->env = new Environment();//$di->getControllerName();
        
        $this->env->_namespace = $this->acl->namespaceNormalize($di->getNamespaceName());
        $this->env->_controller = $di->getControllerName();
        $this->env->_action = $di->getActionName();
        
        $this->env->day = "16";
        $this->env->ip = "blah";
        
        $this->user = new User();
        
        $user = Users::findFirstById(1); //auth cap
        $this->user->id = $user->id;
        $this->user->group = $user->group->group_id;
        
        try {
			$policies = (array)$this->calculateRight(); //we can add any common policies to this array
			
			if ($this->watchdog->checkAccess($policies, $this->env, $this->user) === false) throw new \Exception("Access denied");
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
