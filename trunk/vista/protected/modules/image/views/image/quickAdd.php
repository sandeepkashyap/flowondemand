<table style="display:none">
<tr>
	<td class="thumbnail">
    	<div class="editableFile" id="vc_image:<?=$model->id_image?>" title="Click to edit. Enter to save. Escapse to cancel" style="width: 150px">
	    	<img src="<?=Yii::app()->createUrl("/site/thumbnail/image/$model->vc_image")?>" alt="<?=$model->vc_name?>"/>
		</div>
	</td>   
    <td class="name">
    	<div class="editableInput" id="vc_name:<?=$model->id_image?>" title="Click to edit. Enter to save. Escapse to cancel"><?php echo $model->vc_name; ?></div>
    </td>
    <td class="hardbreak editableInput" id="vc_url:<?=$model->id_image?>" title="Click to edit. Enter to save. Escapse to cancel"><?php echo CHtml::encode($model->vc_url); ?></td>
    <td align="center"><?php echo $model->dt_received? Yii::app()->dateFormatter->format('MMM. dd yyyy H:m:s', $model->dt_received) : ''; ?></td>
	<td align="center">
		<?php if ($model->dt_indexed):?>
			<?php 
				list($indicator, $message) = $model->getIndicator();
			?>
			<img alt="<?=$indicator?>" src="<?=Html::getImageUrl($indicator . "_indicator.gif")?>" alt="<?=$indicator . " " . $message?>" title="<?=$indicator . " " . $message?>"/>
			<?php echo $model->dt_indexed ? Yii::app()->dateFormatter->format('MMM. dd yyyy H:m:s', $model->dt_indexed) : ''; ?>
		<?php endif;?>
	</td>
    <td class="action">
    	<a href="#delete" rel="<?=$model->id_image?>" title="Delete">
  			<img alt="delete" src="<?=Html::getImageUrl('gray-delete.gif')?>"/>
  		</a>
		<a href="<?=Yii::app()->createUrl('image/image/viewFull', array('id'=>$model->id_image, 'rand'=>time().'.jpg'))?>" rel="fancy_group" class="fancy_group" int_width="<?=$model->int_width?>" int_height="<?=$model->int_height?>">
	  		<img alt="full_view" src="<?=Html::getImageUrl('full-view.gif')?>"/>
		</a>
		<a href="#manualIndex" rel="<?=$model->id_image?>" title="Manual index">
  			<img alt="manual index" src="<?=Html::getImageUrl('indeximg.png')?>"/>
  		</a>
	</td>
</tr>
</table>