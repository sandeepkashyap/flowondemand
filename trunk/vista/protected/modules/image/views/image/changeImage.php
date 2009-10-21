<div id="replace_upload_container">
	<form id="replace_upload_form" action="<?=Yii::app()->createUrl('image/image/quickUpdate', array('id' => 'vc_image:'.$model->id_image))?>" class="uniForm showErrors" method="post">
		<div class="blockLabels">
			<div class="form_left_col" style="width: 60%">
				<div class="ctrlHolder">
					<label for="Image_vc_image">Image from your computer <em>*</em></label>
					<?php echo CHtml::fileField('value'); ?>
				</div>

				<div class="ctrlHolder">
					<label for="Image_from_url">or from url</label>
					<?php echo CHtml::textField('Image[from_url]', '', array('id'=>'quick_from_url', 'size'=>60,'maxlength'=>128)); ?>
				</div>

				<div class="buttonHolder">
					<?php echo Html::submitButton($update ? 'Upload' : 'Upload'); ?>
					<button value="Reset" name="reset">
						<span>Reset</span>
					</button>
				</div>
			</div>
			<div class="form_right_col" style="width: 30%">
				<img src="<?=Yii::app()->createUrl("/site/thumbnail/image/$model->vc_image", array('rand'=>time()))?>" alt="<?=$model->vc_name?>"/>
			</div>
			<div class="clear"></div>
		</div>
	</form>
</div>