<div id="login_company_logo">
  <img src="{brand what=logo}" alt="{$owner_company->getName()|clean} logo" />
</div>

<div id="auth_dialog_container">
	<div id="auth_dialog_container_inner">
    	<div id="auth_dialog">
    	<?php echo CHtml::form('', 'post', array('id' => 'system_form_2', 'class' => 'uniForm showErrors'));?>
	      	<div class="blockLabels">
	      		<?php echo Html::errorSummary($user); ?>
	      		<div class="auth_elements ctrlHolder">
			        <div class="ctrlHolder">
			          	<?php echo CHtml::activeLabel($user,'username'); ?>
						<?php echo CHtml::activeTextField($user,'username') ?>
			        </div>
			        <div class="ctrlHolder">
			          	<?php echo CHtml::activeLabel($user,'password'); ?>
						<?php echo CHtml::activePasswordField($user,'password') ?>
			        </div>
			        <div class="ctrlHolder">
			          	<label for="loginFormRemember"><input type="checkbox" value="1" tabindex="3" id="loginFormRemember" class="inlineInput inline input_checkbox" name="login[remember]"/> Remember me for 14 days</label>
			        </div>
	      		</div>
		      	<div class="clear"></div>

				<div class="buttonHolder">
		        	<?php echo CHtml::link('Lost your username?', array('user/recover'), array('class'=>'forgot_password_link')); ?>
		        	<?php echo Html::submitButton('Login'); ?>
		      	</div>
		      	<div class="clear"></div>
			</div>
    	</form>
    	</div>
	</div>
</div>