<?php $this->pageTitle=Yii::app()->name . ' - Contact Us'; ?>

<h1>Contact Us</h1>

<?php
if(Yii::app()->user->hasFlash('contact')) {
	Yii::app()->user->flash('contact', array('<div class="confirmation">', '</div>'));
	return;
}

$this->widget('textedit.components.TextEditor', array('id'=>'contact'));
?>

<div class="yiiForm">
<?php echo CHtml::form(); ?>

<?php echo CHtml::errorSummary($contact); ?>

<div class="simple">
<?php echo CHtml::activeLabel($contact,'name'); ?>
<?php echo CHtml::activeTextField($contact,'name'); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabel($contact,'email'); ?>
<?php echo CHtml::activeTextField($contact,'email'); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabel($contact,'subject'); ?>
<?php echo CHtml::activeTextField($contact,'subject',array('size'=>60,'maxlength'=>128)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabel($contact,'body'); ?>
<?php echo CHtml::activeTextArea($contact,'body',array('rows'=>6, 'cols'=>50)); ?>
</div>

<?php if(extension_loaded('gd')){ ?>
<div class="simple">
	<?php echo CHtml::activeLabel($contact,'verifyCode'); ?>
	<div>
	<?php $this->widget('CCaptcha'); ?>
	<?php echo CHtml::activeTextField($contact,'verifyCode'); ?>
	</div>
	<p class="hint">Please enter the letters as they are shown in the image above.
	<br/>Letters are not case-sensitive.</p>
</div>
<?php } ?>

<div class="action">
<?php echo CHtml::submitButton('Submit'); ?>
</div>

</form>
</div><!-- yiiForm -->