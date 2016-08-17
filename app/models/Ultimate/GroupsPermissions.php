<?php

namespace Ultimate\Acl\Models;

use Phalcon\Mvc\Model;

class GroupsPermissions extends Model
{

	public $id;
    public $group_id;
    public $permission_id;
    public $created;
    public $updated;
    public $deleted;

    public function initialize()
    {
        $this->hasOne("permission_id", "Ultimate\\Acl\\Models\\Permissions", "id", array(
            'alias' => 'permissions'
        ));

        $this->hasOne("group_id", "Ultimate\\Acl\\Models\\Group", "id", array(
            'alias' => 'group'
        ));
    }

    public function getSource()
    {
        return "groups_permissions";
    }

}