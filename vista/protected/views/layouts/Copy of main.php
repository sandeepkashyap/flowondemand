<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/2000/REC-xhtml1-200000126/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="en" />
<?php
/*echo CHtml::cssFile(Yii::app()->request->baseUrl.'/css/reset.css');
echo CHtml::cssFile(Yii::app()->request->baseUrl.'/css/typography.css');
echo CHtml::cssFile(Yii::app()->request->baseUrl.'/css/main.css');
echo CHtml::cssFile(Yii::app()->request->baseUrl.'/css/form.css');*/
//echo CHtml::cssFile(Yii::app()->request->baseUrl.'/css/ie.css');
echo CHtml::cssFile('/assets/css.php');
?>
<title><?php echo $this->pageTitle; ?></title>
</head>

<body>
<div id="page">

<div id="header">
<div style="float: right; margin: 8px;">
<?php $this->widget('UserStatus'); ?>
</div>
<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
<div id="mainmenu">
<?php $this->widget('Menu',array(
	'items'=>array(
		array('Home', array('/site/index')),
		array('Contact', array('/site/contact')),
		array('Users', array('/user/list')),
		array('Posts', array('/post/list')),
		array('News Archive', array('/post/news')),
		array('Admin', array('/admin'), 'visible'=>Yii::app()->user->hasAuth(Group::ADMIN)),
	),
	'view' => 'mainMenu'
)); 

//Yii::app()->raiseEvent('onMenu', new CMenuEvent());
$menuEvent = new CMenuEvent();
EventHelper::raiseModuleEvent('onMenu', $menuEvent);
Yii::trace(print_r($menuEvent, true));
?>

</div><!-- mainmenu -->
</div><!-- header -->

<div id="content">

<?php $this->widget('Breadcrumb'); ?>

<?php $this->widget('application.extensions.email.Debug'); ?>
<?php echo $content; ?>
</div><!-- content -->

<div id="footer">
<?php $this->widget('textedit.components.TextEditor', array('id'=>'footer')); ?>
</div><!-- footer -->

</div><!-- page -->
</body>

</html>