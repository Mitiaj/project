<?php
class UserIdentity extends CUserIdentity
{
    private $_id;

    public function authenticate()
    {

        $record=User::model()->findByAttributes(array('login'=>$this->username));
        if($record===null)
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        else if($record->password !== crypt($this->password,$record->password))
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        else
        {
            $this->_id=$record->id;
            switch ($record->userType) {
                case 1:
                    $this->setState('roles','Admin');
                    $this->setState('roleId',1);
                    break;
                case 0:
                    $this->setState('roles','User');
                    $this->setState('roleId',2);
                    break;

            }
            $this->errorCode=self::ERROR_NONE;
        }
        return !$this->errorCode;

    }

    public function getId()
    {
        return $this->_id;
    }
}