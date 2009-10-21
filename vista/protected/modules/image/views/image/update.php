<?php Yii::app()->wireframe->setPageTitle(Yii::t('application', 'Edit ') . 'Image')?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>