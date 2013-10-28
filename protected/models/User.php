<?php

class User extends CActiveRecord
{
    public $verifyCode;
    public $staySignedIn;
    public $passwd2;
    public $roles;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('login, password', 'required'),
			array('password', 'length', 'max'=>150),
			array('login', 'length', 'max'=>120),
			array('password', 'safe'),
            array('password', 'authenticate', 'on' => 'login'),
            //array('password', 'compare', 'compareAttribute'=>'passwd2', 'on'=>'registration'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, surname, date', 'safe', 'on'=>'search'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'User`s id',
			'name' => 'First name',
			'surname' => 'Last name',
			'password' => 'Pasword',
			'salt' => 'Salt of password',
			'profilePicture' => 'Profile Picture',
			'registrationDate' => 'Registration Date',
		);
	}


    public function authenticate($attribute,$params)
    {
         if(!$this->hasErrors())
        {
            $identity= new UserIdentity($this->login, $this->password);

             $identity->authenticate();   
                switch($identity->errorCode)
                {
                    // Если ошибки нету...
                     case UserIdentity::ERROR_NONE: {
                         if(!empty($this->staySignedIn))
                         {
                              Yii::app()->user->login($identity, 3600*24*30);
                              
                         }
                         else
                         {
                             Yii::app()->user->login($identity, 0);
                         }
                        break;
                    }
                    case UserIdentity::ERROR_USERNAME_INVALID: {
                        $this->addError('email','User not found!');
                        break;
                    }
                     case UserIdentity::ERROR_PASSWORD_INVALID: {
                        $this->addError('password','Password incorrect!');
                         break;
                    }
                }
        }

    }
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TblUsers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
