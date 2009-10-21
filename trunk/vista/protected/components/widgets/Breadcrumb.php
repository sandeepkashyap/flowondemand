<?php
/*
 * Created on Jun 19, 2009
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class Breadcrumb extends CWidget {
	
	public $view = 'breadcrumb';
	
	public function run() {		
		$this->render($this->view, array('bread_crumbs' => Yii::app()->wireframe->bread_crumbs));
	}
}
?>
