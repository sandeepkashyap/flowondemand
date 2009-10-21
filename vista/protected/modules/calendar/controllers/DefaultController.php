<?php

class DefaultController extends CController
{
	public function actionIndex()
	{
		echo '2';exit;
		$this->render('index');
	}
}