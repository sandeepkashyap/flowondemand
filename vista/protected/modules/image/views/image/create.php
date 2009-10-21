<?php Yii::app()->wireframe->setPageTitle(Yii::t('application', 'New ') . 'Image')?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>false,
)); ?>