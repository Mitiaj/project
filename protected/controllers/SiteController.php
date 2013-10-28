<?php

class SiteController extends Controller
{
	public function actionError()
	{
	}
    public function actionIndex()
    {
        if(Yii::app()->user->isGuest){
            $this->redirect($this->createUrl('user/login'));
        }else{
            $this->layout = 'main';
            $this->render('mainView');
        }
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
                'actions'=>array('index'),
                'roles'=>array('Administrator','User'),
            ),
            array('deny',
                'actions'=>array('settings'),
                'roles'=>array('Client',''),
            ),
        );
    }

}
