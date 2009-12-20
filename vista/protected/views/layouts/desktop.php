<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
		<?=CHtml::cssFile(ROOT_URL . '/ext/resources/css/ext-all.css');?>
		<?=CHtml::cssFile(ROOT_URL . '/ext/resources/css/xtheme-human.css');?>
		<?=CHtml::cssFile(ROOT_URL . '/ext/resources/css/ux/RowEditor.css');?>
		<?=CHtml::cssFile(ROOT_URL . '/ext/resources/css/ux/RowActions.css');?>
		<?=CHtml::cssFile(ROOT_URL . '/ext/resources/css/ux/icons.css');?>
		<?=CHtml::cssFile(ROOT_URL . '/ext/resources/css/ux/Lightbox.css');?>
		<?=CHtml::cssFile(ROOT_URL . '/assets/stylesheets/overlay-basic.css');?>
		<?=CHtml::cssFile(ROOT_URL . '/assets/stylesheets/overlay-gallery.css');?>
		
		<?=CHtml::cssFile(ROOT_URL . '/assets/stylesheets/fancybox.css');?>
		
		<?=CHtml::scriptFile(ROOT_URL . '/assets/javascript/jquery.js');?>
		
		
		
		<?=CHtml::scriptFile(ROOT_URL . '/ext/adapter/jquery/ext-jquery-adapter.js');?>
		
		<?=CHtml::scriptFile(ROOT_URL . '/assets/javascript/jquery.fancybox.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/assets/javascript/jquery.jeditable.js');?>
		
		
		<?=CHtml::scriptFile(ROOT_URL . '/ext/ext-all.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/ext/ux/FileUploadField.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/ext/ux/RowEditor.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/ext/ux/RowActions.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/ext/ux/Toast.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/ext/ux/MsgBus.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/ext/ux/SliderTip.js');?>
		
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
			App.data.image_quick_add_url = '<?=$this->createUrl('image/quickAdd/application/'. $this->application_id, array('skip_layout'=>1))?>';
			App.data.image_full_url = '<?=Yii::app()->createUrl('image/image/viewFull')?>'
		</script>
		
		<?=CHtml::scriptFile(ROOT_URL . '/js/application.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/js/ApplicationForm.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/js/AppSwitcher.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/js/UploadForm.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/js/EditPictureForm.js');?>
		<?=CHtml::scriptFile(ROOT_URL . '/js/ImagesGrid.js');?>
		
		
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
		
		<!-- overlay element --> 
		<div class="simple_overlay" id="gallery"> 
		 
		    <!-- "previous image" action --> 
		    <a class="prev">prev</a> 
		 
		    <!-- "next image" action --> 
		    <a class="next">next</a> 
		 
		    <!-- image information --> 
		    <div class="info"></div> 
		 
		    <!-- load indicator (animated gif) --> 
		    <img class="progress" src="http://static.flowplayer.org/tools/img/overlay/loading.gif" /> 
		</div>


    </body>
</html>
