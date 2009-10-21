<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/2000/REC-xhtml1-200000126/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="en" />
<?php
echo CHtml::cssFile(ROOT_URL . '/css.php');
echo CHtml::cssFile(ASSETS_URL . '/themes/access/theme.css');

$this->widget('JavascriptRegister');

$module_name = $this->getModule()->getId();
$controller_name = $this->getId();
$action_name = $this->getAction()->getId();
$run_controller_action = "if(App.{$module_name} && App.{$module_name}.controllers.{$controller_name}) {
        		if(typeof(App.{$module_name}.controllers.{$controller_name}.{$action_name}) == 'function') {
          			App.{$module_name}.controllers.{$controller_name}.{$action_name}();
        		}
			}";
Yii::app()->clientScript->registerScript('module.controller.action', $run_controller_action, 4);
?>
<!--[if IE]>
      <link rel="stylesheet" href="<?=ASSETS_URL?>/stylesheets/iefix.css" type="text/css" />
      <link rel="stylesheet" href="<?=ASSETS_URL?>/themes/access/iefix.css" type="text/css" media="screen"/>
<![endif]-->
<title>
<?php
	echo 'Pictomobile::' . Yii::app()->wireframe->getPageTitle();
?>
</title>
</head>

<body style="text-align: left;">
<?php echo $content; ?>
</body>
</html>