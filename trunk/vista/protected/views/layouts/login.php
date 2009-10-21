<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-us" lang="en-us">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <?php
    	echo CHtml::cssFile(ROOT_URL . '/css.php');
		echo CHtml::cssFile(ASSETS_URL . '/themes/access/theme.css');
    ?>
	<!--[if IE]>
    	<link rel="stylesheet" href="<?=ASSETS_URL?>/stylesheets/iefix.css" type="text/css" />
      	<link rel="stylesheet" href="<?=ASSETS_URL?>/themes/access/iefix.css" type="text/css" media="screen"/>
	<![endif]-->

    <title>Login</title>
  </head>
  <body style="margin: 0;">
    <div id="wrapper">
      <!--<h1>{page_title default="Page"}</h1> -->
      <!--{flash_box}-->
      <div id="content"><?=$content?></div>
      <div id="footer">
        <p id="copyright">&copy;2009 by Pictomobile</p>
      </div>
    </div>
  </body>
</html>