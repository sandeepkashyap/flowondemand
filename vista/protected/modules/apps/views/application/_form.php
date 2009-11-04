<?php echo Html::form('', 'post', array('id' => 'form_1', 'class' => 'uniForm showErrors'));?>
<div class="blockLabels">
<?php echo Html::errorSummary($model); ?>
<!--
<div class="ctrlHolder">
<?php echo Html::activeLabelEx($model,'id_client'); ?>
<?php echo Html::activeTextField($model,'id_client'); ?>
</div>
-->
<div class="ctrlHolder">
<?php echo Html::activeLabelEx($model,'vc_name'); ?>
<?php echo Html::activeTextField($model,'vc_name',array('size'=>60,'maxlength'=>128)); ?>
</div>
<div class="ctrlHolder">
<?php echo Html::activeLabelEx($model,'vc_repository'); ?>
<?php echo Html::activeTextField($model,'vc_repository',array('size'=>60,'maxlength'=>128)); ?>
</div>
<div class="ctrlHolder">
<?php echo Html::activeLabelEx($model,'vc_description'); ?>
<?php echo Html::activeTextArea($model,'vc_description',array('rows'=>6, 'cols'=>50)); ?>
</div>
<div class="ctrlHolder">
<?php echo Html::activeLabelEx($model,'int_size'); ?>
<?php echo Html::activeTextField($model,'int_size'); ?>
</div>
<div class="ctrlHolder">
<?php echo Html::activeLabelEx($model,'int_nbanwsers'); ?>
<?php echo Html::activeTextField($model,'int_nbanwsers'); ?>
</div>
<div class="ctrlHolder">
<?php echo Html::activeLabelEx($model,'float_scoremin'); ?>
<?php echo Html::activeTextField($model,'float_scoremin'); ?>
</div>
<div class="ctrlHolder">
<?php echo Html::activeLabelEx($model,'int_tokens'); ?>
<?php echo Html::activeTextField($model,'int_tokens'); ?>
</div>
<div class="ctrlHolder">
<?php echo Html::activeLabelEx($model,'int_teches'); ?>
<?php echo Html::activeTextField($model,'int_teches'); ?>
</div>
<div class="ctrlHolder">
<?php echo Html::activeLabelEx($model,'nm_sens'); ?>
<?php echo Html::activeTextField($model,'nm_sens'); ?>
</div>

<div class="buttonHolder">
<?php echo Html::submitButton($update ? 'Save' : 'Create'); ?>
</div>
</form>
<script>
	$(function() {
		$('#application_vc_repository').blur(function() {
			var vc_repository = $.trim($(this).val());
			if (/.*\s.*/.test(vc_repository)) {
				if (confirm('Respository should not contain spaces. Do you want to replace spaces to "_" - under score character?')) {
					$(this).val(vc_repository.replace(" ", "_"));
				}				
			}
		})
		$('#form_1').submit(function() {
			var form = $(this);
			var vc_repository = $.trim($('#application_vc_repository').val());
			if (/.*\s.*/.test(vc_repository)) {
				alert('Please remove spaces on Respository');
				return false;
			}
			return true;
		})
	});
</script>