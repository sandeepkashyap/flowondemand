<div style="width: 850px; padding: 17px;">
<?php foreach ($models as $n=>$model): ?>
<div style="float: left;">
	<div style="padding: 5px;">
		<img alt="<?=$model->vc_name?>" src="<?=Yii::app()->createUrl('image/image/viewFull', array('id'=>$model->id_image, 'rand'=>time().'.jpg'))?>" width="<?=$width?>"/>		
	</div>
</div>
<?php endforeach; ?>
</div>