<div style="height: 100%; width: 100%;"><?php foreach ($models as $model): ?>
<div class="tile-image"  style="width: <?=110 * $ratio?>px; height: <?=115 * $ratio?>px;">
<table cellspacing="0" cellpadding="0">
	<tbody>
		<tr>
			<td class="td-thumb" style="width: <?=110 * $ratio?>px; height: <?=115 * $ratio?>px;">
				<img
				alt="<?=$model['vc_name']?>"
				src="<?=Yii::app()->createUrl('image/image/viewFull', array('id'=>$model['id_image'], 'rand'=>time().'.jpg'))?>"
				width="<?=$model['width']?>" height="<?=$model['height']?>" /></td>
		</tr>
	</tbody>
</table>
</div>
<?php endforeach; ?>
<div class="x-clear"></div>
</div>