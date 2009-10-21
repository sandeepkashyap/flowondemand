<?php
//  define('ASSETS_PATH', dirname(__FILE__) . '/../css');
  define('ASSETS_PATH', dirname(__FILE__) . '/assets/');

  if(extension_loaded('zlib') && !((boolean) ini_get('zlib.output_compression'))) {
    @ob_start('ob_gzhandler');
  } else {
    ob_start();
  } // if

  // Turn magic quotes OFF
  if(get_magic_quotes_gpc()) {
    set_magic_quotes_runtime(0);
  } // if

  header("Content-type: text/css; charset: UTF-8");
  header("Cache-Control: max-age=8640000");
  header("Expires: " . gmdate("D, d M Y H:i:s", time() + 8640000) . " GMT");

  $files = array(
//    ASSETS_PATH . '/stylesheets/reset.css',
//    ASSETS_PATH . '/stylesheets/typography.css',
//    ASSETS_PATH . '/stylesheets/main.css',
//    ASSETS_PATH . '/stylesheets/form.css',
    ASSETS_PATH . '/stylesheets/global.css',
    ASSETS_PATH . '/stylesheets/jquery-ui.css',
    ASSETS_PATH . '/stylesheets/fancybox.css',
//    ASSETS_PATH . '/stylesheets/datepicker.css',
    ASSETS_PATH . '/stylesheets/tree_component.css',
    ASSETS_PATH . '/stylesheets/uni-form-generic.css',
    ASSETS_PATH . '/stylesheets/uni-form.css',
    ASSETS_PATH . '/stylesheets/pagination.css',
    ASSETS_PATH . '/modules/system/stylesheets/main.css',
    ASSETS_PATH . '/modules/resources/main.css',
  );

  $modules = isset($_GET['modules']) && $_GET['modules'] ? explode(',', trim($_GET['modules'], ',')) : null;
  $d = dir(dirname(__FILE__) . '/protected/modules');

  while(($entry = $d->read()) !== false) {
    if($entry == '.' || $entry == '..' || $entry == 'system' || $entry == 'resources') {
      continue;
    } // if

    if($modules && !in_array($entry, $modules)) {
      continue;
    } // if

    $files[] = ASSETS_PATH . '/modules/' . $entry . '/stylesheets/main.css';
  } // while
  $d->close();
  // Turn magic quotes OFF
  foreach($files as $file) {
    if(!is_file($file)) {
      continue;
    } // if

    print "\n\n/** File: " . substr($file, strlen(ASSETS_PATH) + 1) . " **/\n\n";

    $f = fopen($file, 'r');
    print fread($f, filesize($file));
    fclose($f);
  } // foreach

?>