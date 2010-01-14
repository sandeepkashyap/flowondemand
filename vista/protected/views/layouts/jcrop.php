<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <?= CHtml::cssFile(ROOT_URL.'/assets/stylesheets/jquery.Jcrop.css'); ?>
        <?= CHtml::scriptFile(ROOT_URL.'/assets/javascript/jquery.js'); ?>
        <?= CHtml::scriptFile(ROOT_URL.'/assets/javascript/jquery.Jcrop.min.js'); ?>
        
		<?= CHtml::scriptFile(ROOT_URL.'/js/image_crop.js'); ?>
        <title>Pictomobile</title>
    </head>
    <body>
        <?php echo $content; ?>
    </body>
</html>
