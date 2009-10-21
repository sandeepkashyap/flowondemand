<?php Yii::app()->wireframe->setPageTitle('Update Application ' . $model->vc_name)?>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>