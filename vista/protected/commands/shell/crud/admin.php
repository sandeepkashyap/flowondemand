<?php
/**
 * This is the template for generating the admin view for crud.
 * The following variables are available in this template:
 * - $ID: the primary key name
 * - $modelClass: the model class name
 * - $columns: a list of column schema objects
 */
?>
<?php echo "<?php Yii::app()->wireframe->setPageTitle(Yii::t('application', 'Manage') . '$modelClass')?>"?>
<div id="applications" class="list_view">
<div class="object_list">
<table class="common_table">

  <tr>
    <th><?php echo "<?php echo \$sort->link('$ID'); ?>"; ?></th>
<?php foreach($columns as $column): ?>
    <th><?php echo "<?php echo \$sort->link('{$column->name}'); ?>"; ?></th>
<?php endforeach; ?>
	<th>Actions</th>
  </tr>
<?php echo "<?php foreach(\$models as \$n=>\$model): ?>\n"; ?>
  <tr class="<?php echo "<?php echo \$n%2?'even':'odd';?>"; ?>">
    <td><?php echo "<?php echo CHtml::link(\$model->{$ID},array('show','id'=>\$model->{$ID})); ?>"; ?></td>
<?php foreach($columns as $column): ?>
    <td><?php echo "<?php echo CHtml::encode(\$model->{$column->name}); ?>"; ?></td>
<?php endforeach; ?>
    <td>
      <?php echo "<?php echo CHtml::link('Update',array('update','id'=>\$model->{$ID})); ?>\n"; ?>
      <?php echo "<?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>\$model->{$ID}),
      	  'confirm'=>\"Are you sure to delete #{\$model->{$ID}}?\")); ?>\n"; ?>
	</td>
  </tr>
<?php echo "<?php endforeach; ?>\n"; ?>
</table>
<br/>
<?php echo "<?php \$this->widget('CLinkPager',array('pages'=>\$pages)); ?>" ?>
</div>
</div>