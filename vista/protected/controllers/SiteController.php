<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions() {
		return array(
			// captcha action renders the CAPTCHA image
			// this is used by the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xEBF4FB,
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}
	
	 /**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$contact=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$contact->attributes=$_POST['ContactForm'];
			if($contact->validate())
			{
				$email = Yii::app()->email;
				$email->to = Yii::app()->params['adminEmail'];
				$email->from = $email->replyTo = $contact->email;
				$email->subject = $contact->subject;
				$email->message = $contact->body;
				$email->send();
				
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('contact'=>$contact));
	}
	
	public function actionThumbnail() {		
		$image = $_GET['image'];
		$images_folder = Yii::app()->getModule('image')->images_folder;
		$thumbnail_folder = Yii::app()->getModule('image')->thumbnails_folder;
		if (!file_exists($thumbnail_folder . $image . ".jpg")) {
			if (SThumbnail::scale_image($images_folder . $image, $thumbnail_folder . $image . ".jpg", 100, 100)) {
			} else {
			}
		}
		header('Content-Type: image/jpg');
		readfile($thumbnail_folder . $image . ".jpg");
		flush();
		exit;
	}
	
	public function actionHello() {
		Yii::log('Yii hello');
		for($i = 0; $i < 100; $i++) {
			Yii::log("i: $i");
			echo "i: $i<br/>";			
		}
		sleep(40);
	}
}