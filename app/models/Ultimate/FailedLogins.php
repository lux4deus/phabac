<?php
namespace Ultimate\Acl\Models;

use Phalcon\Mvc\Model;

/**
 * FailedLogins
 * This model registers unsuccessfull logins registered and non-registered users have made
 */
class FailedLogins extends Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $user_id;

    /**
     *
     * @var string
     */
    public $ipAddress;

    /**
     *
     * @var integer
     */
    public $created;

    public function initialize()
    {
        $this->belongsTo('user_id', "Ultimate\\Models\\Users", 'id', array(
            'alias' => 'user'
        ));
    }
}
