<?php $retval = array(); 
	foreach($models as $n=>$model) {
		$retval[] = array(
			'id' => $model->id,
    		'id_client' => $model->id_client,
    		'int_nbanwsers' => $model->int_nbanwsers,
    		'int_tokens' => $model->int_tokens,
    		'int_size' => $model->int_size,
    		'float_scoremin' => $model->float_scoremin,        		 
    		'int_teches' => $model->int_teches,        		 
    		'vc_name' => $model->vc_name,        		 
    		'vc_repository' => $model->vc_repository,        		 
    		'vc_description' => $model->vc_description,        		 
    		'nm_sens' => $model->nm_sens,        		 
		);
	} 
?>
{
	totalCount: <?= $pages->getItemCount() ?>,
    apps: <?= CJSON :: encode($retval)?>
}
