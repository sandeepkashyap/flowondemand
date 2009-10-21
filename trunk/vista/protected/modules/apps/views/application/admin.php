<?php Yii::app()->wireframe->setPageTitle('Manage Applications')?>
<div id="applications" class="list_view">
<div class="object_list">
<table class="common_table">
<tbody>
  <tr>
    <th><?php echo $sort->link('id'); ?></th>
    <th><?php echo $sort->link('id_client'); ?></th>
    <th><?php echo $sort->link('int_size'); ?></th>
    <th><?php echo $sort->link('int_nbanwsers'); ?></th>
    <th><?php echo $sort->link('float_scoremin'); ?></th>
    <th><?php echo $sort->link('int_tokens'); ?></th>
    <th><?php echo $sort->link('int_teches'); ?></th>
    <th><?php echo $sort->link('nm_sens'); ?></th>
    <th><?php echo $sort->link('vc_name'); ?></th>
    <th><?php echo $sort->link('vc_description'); ?></th>
	<th>Actions</th>
  </tr>
</tbody>
</tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->id,array('show','id'=>$model->id)); ?></td>
    <td><?php echo CHtml::encode($model->id_client); ?></td>
    <td><?php echo CHtml::encode($model->int_size); ?></td>
    <td><?php echo CHtml::encode($model->int_nbanwsers); ?></td>
    <td><?php echo CHtml::encode($model->float_scoremin); ?></td>
    <td><?php echo CHtml::encode($model->int_tokens); ?></td>
    <td><?php echo CHtml::encode($model->int_teches); ?></td>
    <td><?php echo CHtml::encode($model->nm_sens); ?></td>
    <td><?php echo CHtml::encode($model->vc_name); ?></td>
    <td><?php echo CHtml::encode($model->vc_description); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->id)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->id),
      	  'confirm'=>"Are you sure to delete #{$model->id}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
</tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>
</div>
</div>