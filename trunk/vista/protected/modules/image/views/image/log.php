<?php
	if (!$skip_layout):
?>
<div class="list_view">
    <div id="index_log" class="object_list">
        <table class="common_table">
            <tr>
                <th width="15%">Id</th>
                <th width="15%">Date</th>
                <th width="15%">Image</th>
                <th width="15%">Keypoint</th>
                <th>Message</th>                
            </tr>
            <tbody id="body_list_logs">
<?php endif;?>
            <?php foreach ($models as $m):
            	$image = Image::model()->findByPk($m->id_image);             
			?>
				<tr>
					<td><?php echo $m->id?></td>
					<td><?php echo $m->dt_created ? Yii::app()->dateFormatter->format('MMM. dd yyyy h:m:s', $m->dt_created) : ''; ?></td>
					<td class="thumbnail">
				    	<img src="<?=Yii::app()->createUrl("/site/thumbnail/image/$image->vc_image")?>" alt="<?=$image->vc_name?>"/>
				    </td>
					<td><?= $m->int_keypoint?></td>
					<td>
						<?php 
							list($indicator, $message) = $m->getIndicator();
						?>
						<img alt="<?=$indicator?>" src="<?=Html::getImageUrl($indicator . "_indicator.gif")?>" alt="<?=$indicator . " " . $message?>"/>&nbsp; <?=$message?>
					</td>
				</tr>
				<?php endforeach; ?>
<?php
	if (!$skip_layout):
?>      
	        </tbody>
        </table>
		<div class="clear"></div>
		<?php
			if (!$is_ajax) {
				echo '<div class="pagination"></div>';
			}
		//	$this->widget('CLinkPager',array('pages'=>$pages));
		?>
    </div>
</div>
<?php else:?>
	<script>
		App.image.ManageLogs.init_pagination('index_log', <?=$pages->getItemCount()?>, <?=$pages->getCurrentPage()?>);
	</script>
<?php endif;?>