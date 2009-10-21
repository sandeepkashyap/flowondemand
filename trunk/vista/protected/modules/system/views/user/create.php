<h2>Register</h2>

<?php echo CHtml::form('create', 'post', array('id' => 'form_1', 'class' => 'uniForm showErrors')); ?>
<div class="blockLabels">
<fieldset>
<?php echo CHtml::errorSummary($user); ?>

<div class="ctrlHolder">
<?php echo CHtml::activeLabel($user,'username'); ?>
<?php echo CHtml::activeTextField($user,'username', array('class' => 'required')); ?>
</div>
<div class="ctrlHolder">
<?php echo CHtml::activeLabel($user,'password'); ?>
<?php echo CHtml::activePasswordField($user,'password'); ?>
</div>
<div class="ctrlHolder">
<?php echo CHtml::activeLabel($user,'password_repeat'); ?>
<?php echo CHtml::activePasswordField($user,'password_repeat'); ?>
</div>
<div class="ctrlHolder">
<?php echo CHtml::activeLabel($user,'email'); ?>
<?php echo CHtml::activeTextField($user,'email'); ?>
<p class="hint">Email will not be viewable by <b>anyone</b> but yourself.</p>
</div>

<div class="action">
<?php echo CHtml::submitButton('Create'); ?>
</fieldset>
</div>
</form>
</div><!-- yiiForm -->
<script type="text/javascript">
1$('#form_1').uniform();
</script>