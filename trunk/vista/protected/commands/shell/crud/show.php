<?php
/**
 * This is the template for generating the show view for crud.
 * The following variables are available in this template:
 * - $ID: the primary key name
 * - $modelClass: the model class name
 * - $columns: a list of column schema objects
 */
?>
<?php echo "<?php Yii::app()->wireframe->setPageTitle(Yii::t('application', 'View ') . '$modelClass' . ' \$model->{$ID}')?>"?>

<table class="common_table">
<?php foreach($columns as $name=>$column): ?>
<tr>
	<th class="label"><?php echo "<?php echo CHtml::encode(\$model->getAttributeLabel('$name')); ?>\n"; ?></th>
    <td><?php echo "<?php echo CHtml::encode(\$model->{$name}); ?>\n"; ?></td>
</tr>
<?php endforeach; ?>
</table>