<?php

namespace Ultimate\Acl\Models;

use Phalcon\Mvc\Model;

class Permissions extends Model
{
	public $id;
    public $name;
    public $resource;
    public $allowed;
    public $created;
    public $updated;
    public $deleted;

    public function getSource()
    {
        return "permissions";
    }

}