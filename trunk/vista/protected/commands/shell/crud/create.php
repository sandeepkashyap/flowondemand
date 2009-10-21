<?php
/**
 * This is the template for generating the create view for crud.
 * The following variables are available in this template:
 * - $ID: the primary key name
 * - $modelClass: the model class name
 * - $columns: a list of column schema objects
 */
?>
<?php echo "<?php Yii::app()->wireframe->setPageTitle(Yii::t('application', 'New ') . '$modelClass')?>"?>

<?php echo "<?php echo \$this->renderPartial('_form', array(
	'model'=>\$model,
	'update'=>false,
)); ?>"; ?>
