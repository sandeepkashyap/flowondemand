<?php
class Html extends CHtml {
	/**
	* Makes the given URL relative to the /image directory
	*/
	public static function imageUrl($url) {
		return Yii::app()->baseUrl.'/images/'.$url;
	}
	public static function cssUrl($url) {
		return Yii::app()->baseUrl.'/css/'.$url;
	}
	public static function jsUrl($url) {
		return Yii::app()->baseUrl.'/js/'.$url;
	}
	
	public static function cssAll() {
		Yii::trace(CSS_PATH);
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
		    CSS_PATH . '/reset.css',
		    CSS_PATH . '/typography.css',
		    CSS_PATH . '/main.css',
		    CSS_PATH . '/form.css',
//		    CSS_PATH . '/stylesheets/global.css',
//		    CSS_PATH . '/modules/system/stylesheets/main.css',
//		    CSS_PATH . '/stylesheets/jquery.ui.css',
//		    CSS_PATH . '/stylesheets/datepicker.css',
//		    CSS_PATH . '/stylesheets/tree_component.css',
//		    CSS_PATH . '/stylesheets/uni-form-generic.css',
//		    CSS_PATH . '/stylesheets/uni-form.css',
//		    CSS_PATH . '/modules/resources/stylesheets/main.css',
		  );
		  
		  $modules = isset($_GET['modules']) && $_GET['modules'] ? explode(',', trim($_GET['modules'], ',')) : null;
		  
		  $d = dir(CSS_PATH . '/modules');
		  while(($entry = $d->read()) !== false) {
		    if($entry == '.' || $entry == '..' || $entry == 'system' || $entry == 'resources') {
		      continue;
		    } // if
		    
		    if($modules && !in_array($entry, $modules)) {
		      continue;
		    } // if
		    
		    $files[] = CSS_PATH . '/modules/' . $entry . '/stylesheets/main.css';
		  } // while
		  $d->close();
		  
		  // Turn magic quotes OFF
		  foreach($files as $file) {
		    if(!is_file($file)) {
		      continue;
		    } // if
		    
		    print "\n\n/** File: " . substr($file, strlen(CSS_PATH) + 1) . " **/\n\n";
		    
		    $f = fopen($file, 'r');
		    print fread($f, filesize($file));
		    fclose($f);
		}
	}
	
	public static function jsAll() {
		
	}
	
	public function clean($text) {
		return $text;
	}
	
	public static function submitButton($label='submit',$htmlOptions=array())
	{
		if(!isset($htmlOptions['name']))
			$htmlOptions['name']=self::ID_PREFIX.self::$count++;
		if(!isset($htmlOptions['type']))
			$htmlOptions['type']='submit';
		if(!isset($htmlOptions['value']))
			$htmlOptions['value']=$label;
		self::clientChange('click',$htmlOptions);
		$result = self::openTag('button',$htmlOptions);
		$result .= "<span>$label</span>" . self::closeTag('button'); 
		
		return $result;
	}
	
	function getImageUrl($name, $module = null) {
	    $prefix = $module ? ASSETS_URL . "/modules/$module" : ASSETS_URL;
    	return $prefix . "/images/$name";
  	} // get_image_url
  	
}