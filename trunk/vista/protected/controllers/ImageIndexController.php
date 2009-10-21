<?php 
class ImageIndexController extends CController {
    /**
     * @return array action filters
     */
    public function filters() {
        return array('accessControl'); // perform access control for CRUD operations 
        
    }
    /**
     *
     Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
			array('allow', 
			// allow all users to perform 'list' and 'show' actions 
			'actions'=>array('list'), '
			users'=>array('@'), ), 
		);
    }
	
	public function actionList() {
		echo 122;
	}
    
}