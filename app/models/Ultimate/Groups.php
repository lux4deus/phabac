<?php
namespace Ultimate\Acl\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

class Groups extends Model
{

    public $id;
    public $name;
    public $system_name;
    public $system;
    public $created;
    public $updated;
    public $deleted;

    public function getSource()
    {
        return "groups";
    }

    public function initialize()
    {
        $this->hasMany('id', "Ultimate\\Acl\\Models\\GroupsPermissions", 'group_id', array(
            'alias' => 'groups_permissions'
        ));

    }

}