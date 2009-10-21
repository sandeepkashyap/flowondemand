<?php

class DocumentModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'document.models.*',
			'document.components.*',
		));
		
//		$this->onMenu = array($this, 'handleMenu');		
	}

	public function onMenu($event) {
		$this->raiseEvent('onMenu', $event);
	}

	public function handleMenu($event) {
		$event->menu->addToGroup(array(
      		new MenuItem('document', 'Document', '#', '/assets/images/navigation/projects.gif'),
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
