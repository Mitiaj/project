<?php

class UserController extends Controller
{
    public function actionLogin()
    {
        $form = new User();

        if (!Yii::app()->user->isGuest)
        {
            $this->redirect(Yii::app()->createUrl('site/index'));
        }
        else
        {
            if (!empty($_POST['User']))
            {
                $form->attributes = $_POST['User'];
                if(isset( $_POST['User']['staySignedIn']))
                    $form->staySignedIn = $_POST['User']['staySignedIn'];
                $form->scenario = 'login';
                if($form->validate()) {
                    $this->redirect(Yii::app()->homeUrl);
                }
            }
            $this->pageTitle = "Login";
            $this->layout = 'main';

            Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/bootstrap/css/bootstrap.min.css?001");
            Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/login.css?001");
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl. "/js/jquery.min.js");
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl. "/css/bootstrap/js/bootstrap.min.js");
            $this->render('loginForm', array('form' => $form));
        }
    }

    public function actions()
    {
        return array(
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=> 0x003300,
                'maxLength'=> 3,
                'minLength'=> 3,
                'foreColor'=> 0x66FF66,
            ),
        );
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->user->returnUrl);
    }
    public function actionRegistration()
    {
        $form = new User();
        $this->layout = "none";
        if(!Yii::app()->user->isGuest)
        {
            throw new CException('already registered!');
        }
        else
        {
            if (!empty($_POST['User'])) {
                //print_r($_POST['User']);
                $form->attributes = $_POST['User'];
                $form->verifyCode = $_POST['User']['verifyCode'];
                $form->scenario = 'registration';
                if($form->validate()) {

                    if ($form->model()->count("login = :login", array(':login' => $form->login)))
                    {
                        $form->addError('login', 'Login already in use');
                        $this->render("registration", array('form' => $form));
                    }
                    else
                    {
                        $passwordHash = crypt($form->password, $this->blowfishSalt());
                        $form->password = $passwordHash;
                        $form->save();
                        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/bootstrap/css/bootstrap.min.css?001");
                        $this->render("registrationOk");
                    }

                } else {
                    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/bootstrap/css/bootstrap.min.css?001");
                    $this->render("registration", array('form' => $form));
                }
            } else {
                Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/bootstrap/css/bootstrap.min.css?001");
                $this->render("registration", array('form' => $form));
            }
        }
    }
    private function blowfishSalt($cost = 15)
    {
        if (!is_numeric($cost) || $cost < 4 || $cost > 31) {
            throw new Exception("cost parameter must be between 4 and 31");
        }
        $rand = array();
        for ($i = 0; $i < 8; $i += 1) {
            $rand[] = pack('S', mt_rand(0, 0xffff));
        }
        $rand[] = substr(microtime(), 2, 6);
        $rand = sha1(implode('', $rand), true);
        $salt = '$2a$' . sprintf('%02d', $cost) . '$';
        $salt .= strtr(substr(base64_encode($rand), 0, 22), array('+' => '.'));
        return $salt;
    }

    public function filters() {
        parent::accessRules();
        return array('accessControl',
        );
    }
    public function accessRules() {
        parent::filters();

        return array(
            array('allow',
                'actions'=>array('login'),
                'roles'=>array('Administrator','User'),
            ),
            array('deny',
                'actions'=>array(''),
                'roles'=>array(''),
            ),
        );
    }
}