<?php $retval = array(); 
	foreach($models as $n=>$model) {
		$retval[] = array(
			'id_image' => $model->id_image,
    		'vc_image' => $model->vc_image,
    		'vc_name' => $model->vc_name,
    		'vc_url' => $model->vc_url,
    		'dt_created' => $model->dt_received,
    		'dt_indexed' => $model->dt_indexed,        		 
		);
	} 
?>
{
	totalCount: <?= $pages->getItemCount() ?>,
    images: <?= CJSON :: encode($retval)?>
}
