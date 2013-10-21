<?php

class SiteController extends Controller
{
	public $layout='column1';

	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}
    public function actionIndex()
    {

        $this->layout = 'column1';
        $this->render('mainView');
    }

}
