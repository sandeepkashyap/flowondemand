<?php Yii::app()->wireframe->setPageTitle(Yii::t('application', 'Manage ') . 'images')?>
<div class="list_view">
<div id="images" class="object_list">
	
<table width="100%">
	<tr>
		<td width="200px">
			<a id="switch_thumb" class="switch_thumb" href="#">Switch Thumb</a> 
		</td>
		<td width="350px">
			<div id="slider"></div> 
		</td>
		<td width="70px" align="right">
			<button value="Print" name="print" id="print_button" style="display:none">
				<span>Print</span>
			</button> 
		</td>
	</tr>
</table>
<div style="clear: both;"></div>
<div id="images_wrapper">
<table class="common_table">
	<tr>
	    <th>Thumbnail</th>
	    <th><?php echo $sort->link('vc_name'); ?></th>
	    <th><?php echo $sort->link('vc_url'); ?></th>
	    <th><?php echo $sort->link('dt_received'); ?></th>
	    <th><?php echo $sort->link('dt_indexed'); ?></th>
		<th class="action">Actions</th>
	</tr>
	<tbody id='body_list_images'>
	<tr id="temp_row" style="display:none">
    	<td colspan="100%"><img src="<?=Html::getImageUrl('indicator.gif')?>" alt="Uploading..."/></td>
  	</tr>
	<?php foreach($models as $n=>$model): ?>
	<tr>
	    <td class="thumbnail">
	    	<div class="editableFile" id="vc_image:<?=$model->id_image?>" title="Click to edit. Enter to save. Escapse to cancel"><img src="<?=Yii::app()->createUrl("/site/thumbnail/image/$model->vc_image")?>" alt="<?=$model->vc_name?>"/></div>
	    </td>
	    <td class="name">
	    	<div class="editableInput" id="vc_name:<?=$model->id_image?>" title="Click to edit. Enter to save. Escapse to cancel"><?php echo $model->vc_name?></div>
	    </td>
	    <td class="hardbreak editableInput" id="vc_url:<?=$model->id_image?>" title="Click to edit. Enter to save. Escapse to cancel"><?php echo CHtml::encode($model->vc_url)?></div></td>
	    <td align="center"><?php echo $model->dt_received? Yii::app()->dateFormatter->format('MMM. dd yyyy H:m:s', $model->dt_received) : ''; ?></td>
	    <td align="center">	
			<?php if ($model->dt_indexed):?>
				<?php 
					list($indicator, $message) = $model->getIndicator();
				?>
				<img alt="<?=$indicator?>" src="<?=Html::getImageUrl($indicator . "_indicator.gif")?>" alt="<?=$indicator . " " . $message?>" title="<?=$indicator . " " . $message?>"/>
				
				<?php echo $model->dt_indexed ? Yii::app()->dateFormatter->format('MMM. dd yyyy H:m:s', $model->dt_indexed) : ''; ?>
			<?php endif;?>
		</td>
	    <td class="action" nowrap="nowrap">
	  		<a href="#delete" rel="<?=$model->id_image?>" title="Delete">
	  			<img alt="delete" src="<?=Html::getImageUrl('gray-delete.gif')?>"/>
	  		</a>
	  		<a href="<?=Yii::app()->createUrl('image/image/viewFull', array('id'=>$model->id_image, 'rand'=>time().'.jpg'))?>" rel="fancy_group" class="fancy_group" int_width="<?=$model->int_width?>" int_height="<?=$model->int_height?>">
	  			<img alt="full_view" src="<?=Html::getImageUrl('full-view.gif')?>"/>
	  		</a>
	  		<a href="#manualIndex" rel="<?=$model->id_image?>" title="Manual index">
	  			<img alt="manual index" src="<?=Html::getImageUrl('indeximg.png')?>"/>
	  		</a>
		</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
</table><!-- end common_table-->
</div><!--end: images_wrapper-->
<div class="clear"></div>
<?php
//	$this->widget('CLinkPager',array('pages'=>$pages));
	echo '<div class="pagination"></div>'
?></div>

<ul id="image_categories" class="category_list">
    <li id="images_all" class="selected" rel="all_image"><a href="#all_images"><span><?=Yii::t('application', 'All images')?></span></a></li>
    <li id="images_indexed" rel="indexed_images"><a href="#indexed_images"><span><?=Yii::t('application', 'Indexed images')?></span></a></li>
    <li id="images_undexed" rel='unindexed_images'><a href="#unindexed_images"><span><?=Yii::t('application', 'Unindexed images')?></span></a></li>
</ul>

<div class="clear"></div>
</div>
<div id="quick_image_form" class="object_list">
	<div class="head">
		<h2 class="section_name">
			<span class="section_name_span">
        		<span class="section_name_span_span">Quick add image</span>
        		<!--a href="#" id="trigger_csv_form"><span class="section_name_span_span" style="float: right;">Upload CSV file</span></a-->
				<a href="<?=Yii::app()->createUrl('image/image/csvForm', array('application'=>$this->application_id))?>" class="iframe" id="trigger_csv_form"><span class="section_name_span_span" style="float: right;">Upload CSV file</span></a>
				<div class="clear"/>
        	</span>
        </h2>
	</div>
	<div class="body">
		<div id="quick_form_image">
			<?php $model = new Image; echo CHtml::form(Yii::app()->createUrl('image/image/quickAdd/application/'. $this->application_id, array('skip_layout'=>1)), 'post', array('id' => 'image_form', 'class' => 'uniForm showErrors', 'enctype' => 'multipart/form-data'));?>
				<div class="blockLabels">

			<div class="form_left_col">
				<div class="ctrlHolder">
					<label for="Image_vc_image">Image from your computer <em>*</em></label>
					<?php echo CHtml::activeFileField($model,'vc_image'); ?>
				</div>

				<div class="ctrlHolder">
					<label for="Image_from_url">or from url</label>
					<?php echo CHtml::textField('Image[from_url]', '', array('id'=>'image_from_url', 'size'=>60,'maxlength'=>128)); ?>
				</div>

				<div class="ctrlHolder">
					<?php echo CHtml::activeLabelEx($model,'vc_name'); ?>
					<?php echo CHtml::activeTextField($model,'vc_name',array('size'=>60,'maxlength'=>128)); ?>
				</div>

				<div class="ctrlHolder">
					<label for="Image_vc_url">Url <em>*</em></label>
					<?php echo CHtml::activeTextField($model,'vc_url',array('class'=>'required')); ?>
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
		</div><!--end blockLabels-->
			</form>
			<script type="text/javascript">$('#image_form').uniform();</script>
		</div>
	</div>
</div>
</div>