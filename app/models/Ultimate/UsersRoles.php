<?php
namespace Ultimate\Acl\Models;

use Phalcon\Mvc\Model;

class UsersRoles extends Model {


    public function initialize()
    {

        //$this->setConnectionService('db_default');
        //$this->setSource("users_roles");

        $this->belongsTo("user_id", 'Ultimate\Acl\Models\Users', "user_id", array('alias' => 'users'));
        $this->belongsTo("role_id", 'Ultimate\Acl\Models\Roles', "role_id", array('alias' => 'roles'));

    }

    public function getSource(){
        return 'users_roles';
    }


}