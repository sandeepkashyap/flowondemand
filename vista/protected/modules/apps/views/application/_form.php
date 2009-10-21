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