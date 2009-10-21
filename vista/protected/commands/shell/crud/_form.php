<?php
/**
 * This is the template for generating the form view for crud.
 * The following variables are available in this template:
 * - $ID: the primary key name
 * - $modelClass: the model class name
 * - $columns: a list of column schema objects
 */
?>
<div class="yiiForm">

<?php echo "<?php echo CHtml::form('create', 'post', array('id' => 'form_1', 'class' => 'uniForm showErrors'));?>\n" ?>
<div class="blockLabels">
<fieldset>
<?php echo "<?php echo CHtml::errorSummary(\$model); ?>\n"; ?>

<?php foreach($columns as $name=>$column): ?>
<div class="ctrlHolder">
<?php echo "<?php echo ".$this->generateInputLabel($modelClass,$column)."; ?>\n"; ?>
<?php echo "<?php echo ".$this->generateInputField($modelClass,$column)."; ?>\n"; ?>
</div>
<?php endforeach; ?>

<div class="action">
<?php echo "<?php echo CHtml::submitButton(\$update ? 'Save' : 'Create'); ?>\n"; ?>
</fieldset>
</div>
</form>
</div><!-- yiiForm -->
<!-- yiiForm -->