<?php
class PageAction extends CWidget {
	public function run() {
		$this->render('page_action', array(
			'page_actions' => Yii::app()->wireframe->getSortedPageActions(),
			'print_button' => Yii::app()->wireframe->print_button
		));
	}
}
?>