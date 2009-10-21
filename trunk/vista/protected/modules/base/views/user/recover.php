<div id="login_company_logo">
  <img src="{brand what=logo}" alt="{$owner_company->getName()|clean} logo" />
</div>

<div id="auth_dialog_container">
	<div id="auth_dialog_container_inner">
    	<div id="auth_dialog">
		<?php echo CHtml::form('', 'post', array('id' => 'system_form_2', 'class' => 'uniForm showErrors')); ?>

			<div class="blockLabels">
		    	<?php if(Yii::app()->user->hasFlash('recover')) :?>
					<div class="auth_elements">
		                  <?=Yii::app()->user->flash('recover', array('<p>', '</p>'));?>
		            </div>
		            <div class="buttonHolder">
						<a class="forgot_password_link" href="<?=Yii::app()->createUrl('base/user/login')?>">Back to Login Form</a>
					</div>
				<?php return; endif;?>

				<?php echo CHtml::errorSummary($user); ?>
				<div class="auth_elements ctrlHolder">
					<div class="ctrlHolder">
					<label for='email'>Email address</label>
					<?php echo CHtml::activeTextField($user,'email') ?>
					</div>
				</div>
				<div class="clear"></div>

				<div class="buttonHolder">
					<a class="forgot_password_link" href="<?=Yii::app()->createUrl('system/user/login')?>">Back to Login Form</a>
					<?php echo Html::submitButton('Submit'); ?>
				</div>
			</div>

		</form>
    	</div>
	</div>
</div>