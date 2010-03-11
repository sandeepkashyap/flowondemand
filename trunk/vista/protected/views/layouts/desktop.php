<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      	<meta http-equiv="X-UA-Compatible" content="IE=7">
      	
		<?=CHtml::cssFile(ROOT_URL . '/ext/resources/css/ext-all.css');?>
		<?=CHtml::cssFile(ROOT_URL . '/ext/resources/css/ux/RowActions.css');?>
		<?=CHtml::cssFile(ROOT_URL . '/ext/resources/css/ux/icons.css');?>
		<?=CHtml::cssFile(ROOT_URL . '/ext/resources/css/ux/FillSlider.css');?>
		<?=CHtml::cssFile(ROOT_URL . '/ext/resources/css/ux/statusbar.css');?>
		
		<?=CHtml::cssFile(ROOT_URL . '/assets/stylesheets/fancybox.css');?>
		
		<?=CHtml::scriptFile(ROOT_URL . '/assets/javascript/jquery.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/ext/adapter/jquery/ext-jquery-adapter.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/assets/javascript/jquery.fancybox.js');?>
		
		<?=CHtml::scriptFile(ROOT_URL . '/ext/ext-all.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/ext/ux/FileUploadField.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/ext/ux/DefaultButton.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/ext/ux/RowEditor.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/ext/ux/RowActions.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/ext/ux/Toast.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/ext/ux/MsgBus.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/ext/ux/SliderTip.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/ext/ux/FillSlider.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/ext/ux/StatusBar.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/ext/ux/FuzzyDate.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/ext/ux/PagingStore.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/ext/ux/FormTableLayout.js');?>
		
		<?=CHtml::cssFile(ROOT_URL . '/css/application.css');?>
		
		<script>
			var App = window.App || {};

			App.data = {};
			
			App.extendUrl = function(url, extend_with) {
			  if(!url || !extend_with) {
			    return url;
			  } // if
			
			  var extended_url = url;
			  var parameters = [];
			
			  extended_url += extended_url.indexOf('?') < 0 ? '?' : '&';
			
			  for(var i in extend_with) {
			    if(typeof(extend_with[i]) == 'object') {
			      for(var j in extend_with[i]) {
			        parameters.push(i + '[' + j + ']' + '=' + extend_with[i][j]);
			      } // for
			    } else {
			      parameters.push(i + '=' + extend_with[i]);
			    } // if
			  } // for
			
			  return extended_url + parameters.join('&');
			};
			
			App.data.homepage_url = '<?=ROOT_URL?>';
			App.data.assets_url = '<?=ASSETS_URL?>';
			App.data.thumnail_url = '<?=Yii::app()->createUrl('site/thumbnail/image/')?>';
			
			App.data.apps_store = '<?=Yii::app()->createUrl('apps/application/list/')?>';
			App.data.images_store = '<?=$this->createUrl('image/getPage/application/'. $this->application_id)?>';
			App.data.logs_store = '<?=$this->createUrl('image/log/')?>';
			
			App.data.image_quick_add_url = '<?=$this->createUrl('image/quickAdd/application/'. $this->application_id, array('skip_layout'=>1))?>';
			App.data.image_full_url = '<?=Yii::app()->createUrl('image/image/viewFull')?>'
			App.data.image_quick_update_url = '<?=Yii::app()->createUrl('image/image/quickUpdate')?>'
			App.data.image_delete_url = '<?=Yii::app()->createUrl('image/image/delete')?>'
			App.data.image_undo_trash_url = '<?=Yii::app()->createUrl('image/image/undoTrash')?>'
			App.data.image_manual_index_url = '<?=Yii::app()->createUrl('image/image/manualIndex')?>'
			App.data.image_change_url = '<?=Yii::app()->createUrl('image/image/changeImage')?>'
			App.data.image_csv_url = '<?=Yii::app()->createUrl('/image/image/batchUpload')?>'
			App.data.image_crop_url = '<?=Yii::app()->createUrl('/image/image/crop')?>'
			App.data.image_print_url = '<?=Yii::app()->createUrl('/image/image/print')?>'
			
			App.data.logout_url = '<?=Yii::app()->createUrl('/base/user/logout')?>'
			App.data.changepassword_url = '<?=Yii::app()->createUrl('/base/user/changePassword')?>'
			
			App.data.apps_create_url = '<?=Yii::app()->createUrl('/apps/application/create')?>'
			App.data.apps_update_url = '<?=Yii::app()->createUrl('/apps/application/update')?>'
			App.data.apps_change_last_application_url = '<?=Yii::app()->createUrl('/apps/application/changeLastApplication')?>'

			App.data.user_fullname = '<?=Yii::app()->user->email?>';
		</script>
		
		<?=CHtml::scriptFile(ROOT_URL . '/js/application.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/js/ApplicationForm.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/js/AppSwitcher.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/js/UploadForm.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/js/UploadCsvForm.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/js/UploadZipForm.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/js/EditPictureForm.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/js/ImagesGrid.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/js/LogsGrid.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/js/PreferencesForm.js');?>
		
		
		
        <title>Pictomobile</title>
    </head>
    <body>
    	<noscript>You should enable Javascript to run this application</noscript>
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
        
		<div id="dialogCsvUpload" class="x-hidden">
            <div class="x-window-header">
                Upload csv file
            </div>
            <div class="x-window-body">
                <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" class="cssPleaseWait">
                    <tr>
                        <td align="center" valign="middle">
                            <iframe id="upload_target" name="upload_target" width="100%" height="100%" style="border: none;">
                            	
                            </iframe>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
		
		<div id="dialogZipUpload" class="x-hidden">
            <div class="x-window-header">
                Upload image zip file
            </div>
            <div class="x-window-body">
                <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" class="cssPleaseWait">
                    <tr>
                        <td align="center" valign="middle">
                            <iframe id="upload_zip_target" name="upload_zip_target" width="100%" height="100%" style="border: none;">
                            	
                            </iframe>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
		
		<div id="dialogCropImage" class="x-hidden">
            <div class="x-window-header">
                Please Wait
            </div>
            <div class="x-window-body">
                <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" class="cssPleaseWait">
                    <tr>
                        <td align="center" valign="middle">
                            <iframe id="if_crop_image" name="if_crop_image" src="http://localhost/vista/index.php/image/image/crop/id/1060" width="100%" height="100%" style="border: none;">
                            	
                            </iframe>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>
