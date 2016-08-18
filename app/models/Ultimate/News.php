<?php
namespace Ultimate\Acl\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

class News extends Model
{
    public $id;
    public $access;
    public $owner;
    public $text;

    public function getSource()
    {
        return "news";
    }

    public function initialize()
    {
        $this->hasOne('owner', 'Ultimate\Acl\Models\Users', 'id', array(
            'alias' => 'owner',
            'reusable' => true
        ));
        
        $this->hasOne('owner', 'Ultimate\Acl\Models\UsersGroups', 'user_id', array(
            'alias' => 'group',
            'reusable' => true
        ));
    }
    
    public function checkAccess()
    {
		
	}
}
