<?php

namespace Ultimate\Acl;

use Phalcon\Mvc\User\Component;
use Ultimate\Acl\Models\Groups;
use Ultimate\Acl\Models\Users;

class Handler extends Component
{

    const DENY = 0;
    const ALLOW = 1;

    protected $_permissions = array();

    const DEFAULT_ROLE = 'guest';

    protected $_namespace = 'index';
    protected $_controller = 'index';
    protected $_action = 'index';

    public function __construct()
    {
        // Дефолтные права для различных ошибок и главной страницы
        $this->_permissions = array(
            //'core_*' => 'frontend_*',
            'core_errors_*' => 'core_errors_*',
            'core_session_*' => 'core_session_*',
            'controlpanel_session_*' => 'controlpanel_session_*',
        );

        // Определяем пользователя
        $identity = $this->auth->getIdentity();

        if($identity){
            // Получаем авторизированного пользователя
            $user = Users::findFirst($identity['id']);
            // Получаем группу пользователя
            $groups = Groups::findFirst($user->group->group_id);

        }else{
            // Ищем дефолтную группу
            $groups = Groups::findFirst(1);
        }

        // Получаем права для группы
        foreach($groups->groups_permissions as $group_permissions){
            $this->_permissions = $this->_permissions + [$group_permissions->permissions->resource => $group_permissions->permissions->resource];
        }

    }

    public function isAllowed($namespace = 'index', $controller = 'index', $action = 'index')
    {

        $namespace = $this->namespaceNormalize($namespace);

        if(stripos($namespace, '_') !== FALSE) {
            //all is in module
            $tmp = explode('_', $namespace);
            $namespace = trim($tmp[0]);
            $controller = trim($tmp[1]);
            $action = trim($tmp[2]);
        }

        if (isset($this->_permissions["{$namespace}_{$controller}_{$action}"])) {
            return self::ALLOW;
        } elseif (isset($this->_permissions["{$namespace}_{$controller}_*"])) {
            return self::ALLOW;
        } elseif (isset($this->_permissions["{$namespace}_*_{$action}"])) {
            return self::ALLOW;
        } elseif (isset($this->_permissions["{$namespace}_*_*"])) {
            return self::ALLOW;
        } elseif (isset($this->_permissions["*_*_*"])) {
            return self::ALLOW;
        }

        return self::DENY;
    }

    public function setController($value) {
        $this->_controller = trim($value);
    }

    public function setAction($value) {
        $this->_action = trim($value);
    }

    public function setNamespace($value)
    {
        $this->_namespace = trim($value);
    }

    public function namespaceNormalize($namespace){
        return strtolower(preg_replace('/\\\Ultimate\\\Controllers\\\/i', '', $namespace));
    }

}