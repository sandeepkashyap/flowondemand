<?php
/*
 * Created on Jun 19, 2009
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class JavascriptRegister extends CWidget {

	public function run() {
		//plugins
		Yii::app()->clientScript->registerScriptFile(ASSETS_URL . '/javascript/date.js');
		Yii::app()->clientScript->registerScriptFile(ASSETS_URL . '/javascript/jquery.form.js');
		Yii::app()->clientScript->registerScriptFile(ASSETS_URL . '/javascript/jquery.blockui.js');
		Yii::app()->clientScript->registerScriptFile(ASSETS_URL . '/javascript/jquery.jeditable.js');
		Yii::app()->clientScript->registerScriptFile(ASSETS_URL . '/javascript/jquery.jeditable.ajaxupload.js');
		Yii::app()->clientScript->registerScriptFile(ASSETS_URL . '/javascript/jquery.ajaxfileupload.js');
		Yii::app()->clientScript->registerScriptFile(ASSETS_URL . '/javascript/jquery.uni-form.js');
		Yii::app()->clientScript->registerScriptFile(ASSETS_URL . '/javascript/jquery.pagination.js');
		Yii::app()->clientScript->registerScriptFile(ASSETS_URL . '/javascript/jquery.ui.js');
		Yii::app()->clientScript->registerScriptFile(ASSETS_URL . '/javascript/jquery.fancybox.js');
		Yii::app()->clientScript->registerScriptFile(ASSETS_URL . '/javascript/jquery.easing.js');
		Yii::app()->clientScript->registerScriptFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js');

		//module js
		Yii::app()->clientScript->registerScriptFile(ASSETS_URL . '/javascript/app.js');
		Yii::app()->clientScript->registerScriptFile(ASSETS_URL . '/modules/system/javascript/main.js');
		Yii::app()->clientScript->registerScriptFile(ASSETS_URL . '/modules/resources/javascript/main.js');
		Yii::app()->clientScript->registerScriptFile(ASSETS_URL . '/modules/image/javascript/main.js');
		Yii::app()->clientScript->registerScriptFile(ASSETS_URL . '/modules/apps/javascript/main.js');

		$js_urls = array(
	        'homepage_url' => ROOT_URL,
	        'assets_url' => ASSETS_URL,
	        'indicator_url' => Html::getImageUrl('indicator.gif'),
	        'big_indicator_url' => Html::getImageUrl('indicator_big.gif'),
	        'ok_indicator_url' => Html::getImageUrl('ok_indicator.gif'),
	        'warning_indicator_url' => Html::getImageUrl('warning_indicator.gif'),
	        'error_indicator_url' => Html::getImageUrl('error_indicator.gif'),
	        'pending_indicator_url' => Html::getImageUrl('pending_indicator.gif'),
	        'url_base' => URL_BASE,
//	        'keep_alive_interval' => KEEP_ALIVE_INTERVAL,
//	        'refresh_session_url' => assemble_url('refresh_session'),
//	        'jump_to_project_url' => assemble_url('jump_to_project_widget'),
//	        'quick_add_url' => assemble_url('quick_add'),
//	        'path_info_through_query_string' => PATH_INFO_THROUGH_QUERY_STRING,
//	        'image_picker_url' => assemble_url('image_picker'),
      	);

      	$prefix = 'App.data';
      	$code = 'if(!App.data) { App.data = {}; }';
      	foreach($js_urls as $k => $v) {
        	$code .= "$prefix.$k = " . CJSON::encode($v) . ";\n";
      	} // foreach

      	Yii::app()->clientScript->registerScript('App.data.urls', $code, 4);
	}
}
?>