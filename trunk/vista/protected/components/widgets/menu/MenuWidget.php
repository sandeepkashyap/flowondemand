<?php

class MenuWidget extends CWidget {

	private $menu;
	
	public function run() {
		$menu = new Menu;
		
		$event = new CMenuEvent($menu);
		EventHelper::raiseModuleEvent('onMenu', $event);
		
		$this->render('menu_widget', array(
			'_menu' => $event->menu			
		));
	}
}
?>
