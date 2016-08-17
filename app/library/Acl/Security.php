<?php

namespace Ultimate\Acl;

class Security extends \Phalcon\Security{

    private $_salt = 'jknfk2fn23f90UI(fk2opfk2l3fkl;KL:fmkl;23f2';

    public function hash($password, $workFactor = 0) {
        return md5($password . $this->_salt);

        //return parent::hash($password, $workFactor = 0);
    }

    public function checkHash($password, $passwordHash, $maxPassLength = 0) {

        if($this->hash($password) == $passwordHash){
            return true;
        }else{
            return false;
        }

        //return parent::hash($password, $passwordHash, $maxPassLength = 0);
    }

}