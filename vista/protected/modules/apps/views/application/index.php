<div class="main_object">
    <div class="body" style="text-align: center">
    	<h2>Select an application</h2><br/>
<?php 
//	$models = application::model()->findAllBySql("SELECT a.* FROM apps a JOIN app_user_admin t ON a.id = t.app_id AND t.user_id = " . Yii::app()->user->id);
	$models = application::model()->findAllBySql("SELECT a.* FROM apps a WHERE a.id_client = " . Yii::app()->user->id . " ORDER BY vc_name");
	$arr_apps = CHtml::listData($models, 'id', 'vc_name');
	$arr_apps[0] = '';
	ksort($arr_apps);
	echo CHtml::dropDownList('id_application', '', $arr_apps, array('style'=>'width: 200px; text-align: center', 'id'=>'id_application')); 
?>
<script language="JavaScript" type="text/javascript">
  
</script>
  	
</div>
</div>