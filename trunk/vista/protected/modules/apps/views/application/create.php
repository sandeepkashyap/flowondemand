<?php Yii::app()->wireframe->setPageTitle('New application')?>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>false,
)); ?>