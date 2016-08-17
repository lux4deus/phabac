<?php
namespace Ultimate\Acl\Models;

use Phalcon\Di;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness;
use Ultimate\Models\Resources;

class Users extends Model
{

    public $id;
    public $first_name;
    public $last_name;
    public $login;
    public $avatar;
    public $email;
    public $password;
    public $must_change_password;
    public $profile_id;
    public $banned;
    public $suspended;
    public $active;
    public $created;
    public $updated;
    public $deleted;

    const ACTIVE = 1;
    const BANNED = 0;

    protected $public_directory;

    public function initialize(){

        $this->hasOne('id', 'Ultimate\Acl\Models\UsersGroups', 'user_id', array(
            'alias' => 'group',
            'reusable' => true
        ));

        $this->hasMany('id', 'Ultimate\Models\SuccessLogins', 'user_id', array(
            'alias' => 'successLogins',
            'foreignKey' => array(
                'message' => 'User cannot be deleted because he/she has activity in the system'
            )
        ));

        $this->hasMany('id', 'Ultimate\Models\PasswordChanges', 'user_id', array(
            'alias' => 'passwordChanges',
            'foreignKey' => array(
                'message' => 'User cannot be deleted because he/she has activity in the system'
            )
        ));

        $this->hasMany('id', 'Ultimate\Models\ResetPasswords', 'user_id', array(
            'alias' => 'resetPasswords',
            'foreignKey' => array(
                'message' => 'User cannot be deleted because he/she has activity in the system'
            )
        ));

        $this->hasMany('id', 'Ultimate\Models\Resources', 'user_id', [
            'foreignKey' =>
                [
                    'action' => Model\Relation::ACTION_CASCADE
                ],
            'alias' => 'UsersResources'
        ]);

        // The account must be confirmed via e-mail
        $this->active = 0;

        // The account is not suspended by default
        $this->suspended = 0;

        // The account is not banned by default
        $this->banned = 0;
    }

    public function beforeCreate(){
        $this->created = time();
    }

    public function beforeUpdate(){
        $this->updated = time();
    }

    /**
     * Before create the user assign a password
     */
    public function beforeValidationOnCreate()
    {
        if (empty($this->password)) {

            // Generate a plain temporary password
            $tempPassword = preg_replace('/[^a-zA-Z0-9]/', '', base64_encode(openssl_random_pseudo_bytes(12)));

            // The user must change its password in first login
            $this->must_change_password = 1;

            // Use this password as default
            $this->password = $this->getDI()
                ->getSecurity()
                ->hash($tempPassword);
        } else {
            // The user must not change its password in first login
            $this->must_change_password = 0;
        }

    }

    /**
     * Send a confirmation e-mail to the user if the account is not active
     */
    /*public function afterSave()
    {
        if ($this->active == 0) {

            $emailConfirmation = new EmailConfirmations();

            $emailConfirmation->user_id = $this->id;

            if ($emailConfirmation->save()) {
                $this->getDI()
                    ->getFlash()
                    ->notice('A confirmation mail has been sent to ' . $this->email);
            }
        }

    }*/

    /**
     * Validate that emails are unique across users
     */
    public function validation()
    {
        $this->validate(new Uniqueness(array(
            "field" => "email",
            "message" => "Указанный e-mail уже зарегистрирован"
        )));

        return $this->validationHasFailed() != true;
    }


    public function getUrl(){
        return '#';
    }


    public function getAvatar($width = 100, $height = 100, $type = NULL){

        // формируем урл отправляем в плагин
        $_avatarDir       = '/uploads/users/avatars/'.$width.'x'.$height.'/';
        $_avatarPath     = $_avatarDir.$this->id.'.jpg';
        $_avatarDirFull   = $this->getDI()->get('config')->application->staticFiles.$_avatarDir;
        $_avatarPathFull = $this->getDI()->get('config')->application->staticFiles.$_avatarPath;

        if(!is_dir($_avatarDirFull))
            @mkdir($_avatarDirFull,0755,true);

        if($this->avatar && file_exists($this->avatar)){
            $avatar = $this->getDI()->get('config')->application->staticFiles.$this->avatar;
        }else{
            $avatar = $this->getDI()->get('config')->application->staticFiles.'/images/no-image.jpg';
        }


        if(!file_exists($_avatarPathFull) && file_exists($avatar))
        {
            if ($type != NULL) {
                \Plugins\ImageMagic::open($avatar)->zoomCrop($width, $height)->save($_avatarPathFull, $type ,90);
            }
            \Plugins\ImageMagic::open($avatar)->zoomCrop($width, $height)->save($_avatarPathFull, 'jpg',90);
        }

        return $_avatarPath;
    }


    public function afterCreate(){

        $identity = Di::getDefault()->get('auth')->getIdentity();
        // Назначаем права на пользователя
        $resources = new Resources();
        $resources->user_id = $identity['id'];
        $resources->resource_id = $this->id;
        $resources->type = Resources::RESOURCE_USERS;
        $resources->created = time();
        $resources->save();

        // TODO: сделать по-человечески ID группы (наследовать для пользователей, назначать админом)
        $user_group = new UsersGroups();
        $user_group->user_id = $this->id;
        $user_group->group_id = 3;
        $user_group->save();
    }


}