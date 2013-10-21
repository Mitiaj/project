<?php

class SiteController extends Controller
{
	public $layout='column1';

	public function actionError()
	{
	}
    public function actionIndex()
    {
        $this->layout = 'column1';
        $this->render('mainView');
    }

}
