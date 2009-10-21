<?php

class ImageModule extends CWebModule
{
	var $images_folder;
	var $thumbnails_folder;
	
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'image.models.*',
			'image.components.*',
		));
		$this->onMenu = array ($this, 'handleMenu');
	}

	public function onMenu($event) {
		$this->raiseEvent('onMenu', $event);
	}

	public function handleMenu($event) {
		$event->menu->addToGroup(array (
			new MenuItem('images', 'Images', Yii::app()->createUrl('/image/image'), '/assets/images/navigation/images.png'),
		), 'main');
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
