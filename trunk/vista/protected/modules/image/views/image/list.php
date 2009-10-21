<?php if (!$skip_layout):?>
<div class="list_view">
<div id="images" class="object_list">
<?php endif;?>
	<ul class="tiled-images">
	<?php foreach($models as $n=>$model): ?>
	<li class="image">
	    <div class="imagethumb">
	    	<a href="<?=Yii::app()->createUrl('image/image/viewFull', array('id'=>$model->id_image, 'rand'=>time().'.jpg'))?>" rel="fancy_group" class="fancy_group" int_width="<?=$model->int_width?>" int_height="<?=$model->int_height?>">
	  			<img alt="<?=$model->vc_name?>" src="<?=Yii::app()->createUrl('image/image/viewFull', array('id'=>$model->id_image, 'rand'=>time().'.jpg'))?>"/>
	  		</a>
	    </div>
	</li>
	<?php endforeach; ?>
	</ul>
	<script>
		//App.image.ManageImages.init_pagination('images', <?=$pages->getItemCount()?>, <?=$pages->getCurrentPage()?>);
	</script>
<?php if (!$skip_layout):?>
</div>
</div>
<?php endif;?>