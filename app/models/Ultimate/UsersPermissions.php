<?php
namespace Ultimate\Acl\Models;

use Phalcon\Mvc\Model;

class UsersPermissions extends Model {


    public function initialize()
    {

        //$this->setConnectionService('db_default');
        //$this->setSource("users_permissions");

        $this->belongsTo("user_id", 'Ultimate\Acl\Models\Users', "user_id", array('alias' => 'users'));
        $this->belongsTo("permission_id", 'Ultimate\Acl\Models\Permissions', "permission_id", array('alias' => 'permissions'));

    }

    public function getSource(){
        return 'users_permissions';
    }


}