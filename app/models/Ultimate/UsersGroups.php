<?php
namespace Ultimate\Acl\Models;

use Phalcon\Mvc\Model;

class UsersGroups extends Model
{

    public $user_id;
    public $group_id;

    public function getSource(){
        return 'users_groups';
    }

}