<?php Yii::app()->wireframe->setPageTitle('Applications');?>

<div class="actionBar">
[<?php echo CHtml::link('New application',array('create')); ?>]
[<?php echo CHtml::link('Manage application',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('id')); ?>:
<?php echo CHtml::link($model->id,array('show','id'=>$model->id)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('id_client')); ?>:
<?php echo CHtml::encode($model->id_client); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('int_size')); ?>:
<?php echo CHtml::encode($model->int_size); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('int_nbanwsers')); ?>:
<?php echo CHtml::encode($model->int_nbanwsers); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('float_scoremin')); ?>:
<?php echo CHtml::encode($model->float_scoremin); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('int_tokens')); ?>:
<?php echo CHtml::encode($model->int_tokens); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('int_teches')); ?>:
<?php echo CHtml::encode($model->int_teches); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('vc_name')); ?>:
<?php echo CHtml::encode($model->vc_name); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('vc_description')); ?>:
<?php echo CHtml::encode($model->vc_description); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>