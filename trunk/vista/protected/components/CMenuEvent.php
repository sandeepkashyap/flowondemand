<?php
class CMenuEvent extends CEvent {
	
	public $arr_menus = array();
	
	public $menu;
	
	function __construct($menu) {
		parent::__construct($menu);
      	$this->menu = $menu;
    } // __construct
}
?>
