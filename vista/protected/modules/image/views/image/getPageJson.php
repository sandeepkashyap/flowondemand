<?php $retval = array(); 
	foreach($models as $n=>$model) {
		$retval[] = array(
			'id_image' => $model->id_image,
    		'vc_image' => $model->vc_image,
    		'vc_name' => $model->vc_name,
    		'vc_url' => $model->vc_url,
    		'int_width' => $model->int_width,
    		'int_height' => $model->int_height,
    		'dt_created' => $model->dt_received ? $model->dt_received : '',
    		'dt_indexed' => $model->dt_indexed && $model->dt_indexed != '0000-00-00 00:00:00' ? $model->dt_indexed : '',
		);
	} 
?>
{
	totalCount: <?= $pages->getItemCount() ?>,
    images: <?= CJSON :: encode($retval)?>
}
