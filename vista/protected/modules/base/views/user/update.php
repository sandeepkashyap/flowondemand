<?php Yii::app()->wireframe->setPageTitle(Yii::t('application', 'Account Settings'))?>

<?php echo CHtml::form('', 'post', array('autocomplete'=>'off', 'class' => 'uniForm showErrors')); ?>
<div class="blockLabels">
<?php echo CHtml::errorSummary($user); ?>

<div class="ctrlHolder">
<?php echo CHtml::activeLabel($user,'email'); ?>
<?php echo CHtml::activeTextField($user,'email'); ?>
<p class="hint">Note: If you change your email address you will be immediately logged out and will not be able to log back in until you revalidate your email address.</p>
</div>

<div class="ctrlHolder">
<?php echo CHtml::activeLabel($user,'about'); ?>
<?php echo CHtml::activeTextArea($user,'about'); ?>
</div>
<div class="ctrlHolder">
<?php echo CHtml::activeLabel($user,'password'); ?>
<?php echo CHtml::activePasswordField($user,'password', array('value'=>'')); ?>
</div>
<div class="ctrlHolder">
<?php echo CHtml::activeLabel($user,'password_repeat'); ?>
<?php echo CHtml::activePasswordField($user,'password_repeat', array('value'=>'')); ?>
</div>

<div class="buttonHolder">
<?php echo Html::submitButton('Save'); ?>
</div>
</div><!--end div blockLabels-->

</form>
