<div class="main_object">
	<div class="body" style="text-align: center">
		<h2>Select an application</h2><br />
		<?php echo CHtml::dropDownList ( 'id_application', '', CHtml::listData ( $models, 'id', 'vc_name' ), array ('style' => 'width: 200px; text-align: center', 'id' => 'id_application', 'empty' => '[Select a application]' ) ); ?>
	</div>
</div>