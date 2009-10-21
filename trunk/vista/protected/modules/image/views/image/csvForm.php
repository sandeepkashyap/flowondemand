<?php $model = new Image; echo CHtml::form(Yii::app()->createUrl('image/image/csvForm/application/'.$this->application_id, array('skip_layout'=>1)), 'post', array('id'=>'csv_form', 'class'=>'uniForm showErrors', 'enctype'=>'multipart/form-data')); ?>
<div class="blockLabels">
    <div class="form_left_col">
        <div class="ctrlHolder">
            <label for="Image_vc_image" style="text-align: left;">
                CSV file <em>*</em>
            </label>
			<input type="file" name="csv_file" style="text-align: left; width: 200px;"/>
			<p class="hint">
			Each entry in the CSV file should have the following format: Image URL ; Image name ; Redirect URL
			You can choose a different delimiter from semicolon (;) by selecting one below.
			</p>
        </div>
        <div class="ctrlHolder">
        	<table>
        		<tr>
        			<td colspan="2">Delimiter:</td>
        		</tr>
        		<tr>
        			<td style="width: 20px;"><input type="radio" name="delimiter" value=";" style="width: 15px; border: none;" checked="true"/></td>
        			<td>;</td>
        		</tr>
        		<tr>
        			<td><input type="radio" name="delimiter" value="," style="width: 15px; border: none;"/></td>
        			<td>,</td>
        		</tr>
        		<tr>
        			<td><input type="radio" name="delimiter" value="|" style="width: 15px; border: none;"/></td>
        			<td>|</td>
        		</tr>
        		<tr>
        			<td><input type="radio" name="delimiter" value="tab" style="width: 15px; border: none;"/></td>
        			<td>tab</td>
        		</tr>
        		<tr>
        			<td><input type="radio" name="delimiter" value="custom" style="width: 15px; border: none;"/></td>
        			<td>Custom: <input type="text" id="delimiter_text" name="delimiter_text" style="width: 20px;" disabled="true"/></td>
        		</tr>
        	</table>            
        </div>
        <div class="buttonHolder">
            <?php echo Html::submitButton($update ? 'Upload' : 'Upload'); ?>
            <button value="Reset" name="reset">
                <span>Reset</span>
            </button>
        </div>
    </div>
    <div class="form_right_col">
    </div>
    <div class="clear"></div>
</div>
<!--end blockLabels-->
</form>
<script type="text/javascript">
	    $('#csv_form').uniform();
		$('#csv_form').submit(function() {
			var form = $(this);
			if (form.find(':file').val() == '') {
				alert('Please select file to upload');
				return false;
			}
			if(!UniForm.is_valid(form)) {
				return false;
			}
			var p = ($(parent.document));
			p.find("#fancy_outer").css({height: "300px", top: "100"});
			return true;
		});
		$('#csv_form').find(":input[name=delimiter]").change(function() {
			if ($(this).val() == 'custom') {
				$('#delimiter_text').attr('disabled', false);
			} else {
				$('#delimiter_text').attr('disabled', true);
			}
		});
</script>