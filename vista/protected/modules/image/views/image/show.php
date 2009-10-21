<div class="main_object">
    <div class="body" style="text-align: center">

<?php Yii::app()->wireframe->setPageTitle(Yii::t('application', 'View ') . 'Image' . ' $model->id_image')?>
<table class="common_table">
<tr>
	<th class="label">Image</th>
    <td><img src="/thumbnails/<?=$model->vc_image?>.jpg" alt="<?=$model->vc_image?>"/></td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('vc_image')); ?>
</th>
    <td><?php echo CHtml::encode($model->vc_image); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('id_application')); ?>
</th>
    <td><?php echo CHtml::encode($model->id_application); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('vc_name')); ?>
</th>
    <td><?php echo CHtml::encode($model->vc_name); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('vc_url')); ?>
</th>
    <td><?php echo CHtml::encode($model->vc_url); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('dt_received')); ?>
</th>
    <td><?php echo CHtml::encode($model->dt_received); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('dt_indexed')); ?>
</th>
    <td><?php echo CHtml::encode($model->dt_indexed); ?>
</td>
</tr>
</table>
</div>
</div>