<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center" valign="middle">
			<img src="<?=Yii::app()->createUrl('image/image/viewFull', array('id'=>$model->id_image, 'rand'=>time().'.jpg'))?>" alt="<?=$model->vc_image?>" id="cropbox" width="<?=$width?>px" height="<?=$height?>px" /><!-- This is the form that our event handler fills -->
			
		    <form name="form_crop_image" action="<?=Yii::app()->createUrl('image/image/crop', array('id'=>$model->id_image, 'rand'=> time()))?>" method="post" onsubmit="return checkCoords();">
		        <input type="hidden" id="x" name="x" /><input type="hidden" id="y" name="y" />
		        <input type="hidden" id="w" name="w" /><input type="hidden" id="h" name="h" />
		        <input type="hidden" id="width" name="width"  value="<?=$width?>"/>
		        <input type="hidden" id="height" name="height" value="<?=$height?>"/>
		        <input type="hidden" id="ratio" name="ratio" value="<?=$ratio?>"/>
		    </form>			
		</td>
	</tr>
</table>