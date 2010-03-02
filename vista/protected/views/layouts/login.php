<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
		<?=CHtml::cssFile(ROOT_URL . '/ext/resources/css/ext-all.css');?>
		<?=CHtml::cssFile(ROOT_URL . '/ext/resources/css/ux/icons.css');?>
		
		<?=CHtml::scriptFile(ROOT_URL . '/ext/adapter/ext/ext-base.js');?>
		
		<?=CHtml::scriptFile(ROOT_URL . '/ext/ext-all.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/ext/ux/Toast.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/ext/ux/DefaultButton.js');?>
		
		<?=CHtml::cssFile(ROOT_URL . '/css/application.css');?>
		
		<script>
			var App = window.App || {};

			App.data = {};
			
			App.data.homepage_url = '<?=ROOT_URL?>';
			App.data.assets_url = '<?=ASSETS_URL?>';
			
			App.data.application_id = 0;
			App.data.application_url = '<?=Yii::app()->createUrl('image/image/list')?>';
			
			App.data.login_url = '<?=Yii::app()->createUrl('/base/user/login')?>'
			App.data.forgot_password_url = '<?=Yii::app()->createUrl('/base/user/recoverPassword')?>'
		</script>
		
		<?=CHtml::scriptFile(ROOT_URL . '/js/LoginWindow.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/js/LoginForm.js');?>
		
        <title>Pictomobile</title>
    </head>
    <body>
        <div id="dialogPleaseWait" class="x-hidden">
            <div class="x-window-header">
                Please Wait
            </div>
            <div class="x-window-body">
                <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" class="cssPleaseWait">
                    <tr>
                        <td align="center" valign="middle">
                            ... Initializing ...
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>
