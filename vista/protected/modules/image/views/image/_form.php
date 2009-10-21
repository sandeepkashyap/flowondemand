<?php echo CHtml::errorSummary($model); ?>

<?php echo CHtml::form('', 'post', array('id' => 'image_form', 'class' => 'uniForm showErrors', 'enctype' => 'multipart/form-data'));?>
<div class="blockLabels">
	
	<div class="form_left_col">
		<div class="ctrlHolder">
			<label for="Image_vc_image">Image from your computer <em>*</em></label>
			<?php echo CHtml::activeFileField($model,'vc_image', array('class'=> 'required')); ?>
		</div>
	
		<div class="ctrlHolder">
			<label for="from_url">or from url</label>
			<?php echo CHtml::textField('from_url', '', array('size'=>60,'maxlength'=>128)); ?>
		</div>
		
		<div class="ctrlHolder">
			<?php echo CHtml::activeLabelEx($model,'vc_name'); ?>
			<?php echo CHtml::activeTextField($model,'vc_name',array('size'=>60,'maxlength'=>128)); ?>
		</div>
		
		<div class="ctrlHolder">
			<label for="Image_vc_url">Url <em>*</em></label>
			<?php echo CHtml::activeTextField($model,'vc_url',array('class'=>'required')); ?>
		</div>
	
		<div class="buttonHolder">
			<?php echo Html::submitButton($update ? 'Save' : 'Create'); ?>
		</div>
	</div>
	
	<div class="form_right_col">
	</div>
	<div class="clear"></div>
</div><!--end blockLabels-->
</form>
<script type="text/javascript">$('#image_form').uniform();</script>
<!-- image_form -->