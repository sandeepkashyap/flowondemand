<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/2000/REC-xhtml1-200000126/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="en" />
<title>
<?php
	echo 'Pictomobile::' . Yii::app()->wireframe->getPageTitle();
?>
</title>
<?=CHtml::cssFile(ROOT_URL . '/ext/resources/css/ext-all.css');?>
<?=CHtml::cssFile(ROOT_URL . '/css/application.css');?>
</head>

<body style="text-align: left;">
<?php echo $content; ?>
</body>
</html>