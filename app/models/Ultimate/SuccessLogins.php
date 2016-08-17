<?php
namespace Ultimate\Acl\Models;

use Phalcon\Mvc\Model;

/**
 * SuccessLogins
 * This model registers successfull logins registered users have made
 */
class SuccessLogins extends Model
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
     * @var string
     */
    public $userAgent;
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
