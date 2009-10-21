	<?php foreach($models as $n=>$model): ?>
	<div class="image">
	    <div class="imagethumb">
	    	<a href="<?=Yii::app()->createUrl('image/image/viewFull', array('id'=>$model->id_image, 'rand'=>time().'.jpg'))?>" rel="fancy_group" class="fancy_group" int_width="<?=$model->int_width?>" int_height="<?=$model->int_height?>">
	  			<img alt="<?=$model->vc_name?>" src="<?=Yii::app()->createUrl("/site/thumbnail/image/$model->vc_image")?>"/>
	  		</a>
	    </div>
	</div>
	<?php endforeach; ?>
	<script>
		//App.image.ManageImages.init_pagination('images', <?=$pages->getItemCount()?>, <?=$pages->getCurrentPage()?>);
	</script>