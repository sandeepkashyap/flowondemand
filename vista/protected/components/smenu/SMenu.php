<?php
/**
 * SMenu widget ver 1.01
 *
 *The widget takes four parameters:<br>
 *<br>
 * 1. menuID:<br>
 *  The Id of the generated menu<br>
 * 2. stylesheet:<br>
 *  The stylesheet to use<br>
 * 3. delay:The delay of the drop down animations.The faster is 2.Default delay is 6.<br>
 * 4. menu:<br>
 *  The menu parameter is an array of arrays.Each array represents a menu item and has the following parameters:<br>
 *   * url - An associative array:<br>
 *<br>
 *     'url'=> array(<br>
 *     'route'=>'/product/create' //The route of the url : controller/action<br>
 *     'link'=>'products/viewList.php' //For a fixed or external link<br>
 *     'params'=>array('id'=>5) //The parameters to pass to the url<br>
 *     'htmlOptions'=>array('target'=>'_BLANK') //options to pass to the menu link tag<br>
 *     )<br>
 *<br>
 *   If url is blank<br>
 *<br>
 *     'url'= '' or 'url'=array()<br>
 *<br>
 *   a menu without a link will be created.<br>
 *   label - The text to display on the menu item<br>
 *<br>
 *   'label'=>'List of Products'<br>
 *<br>
 *   icon - The icon to display before the label<br>
 *<br>
 *   'icon'=>'protected/images/icon.png'<br>
 *<br>
 *   disabled - Whether the link is disabled<br>
 *<br>
 *   'disabled'=>true<br>
 *<br>
 *   visible - Whether the menu is visible<br>
 *<br>
 *   'visible'=>false<br>
 *<br>
 *   If a menu item is not visible all of its' submenus are not visible too.<br>
 **/

class SMenu extends CWidget {
/**
 * The menu items' data
 * @var array
 */
  private $_menu;
  /**
   * The stylesheet to use
   * @var string
   */
  public $stylesheet = "menu_default.css";
  /**
   * The id of the menu
   * @var string
   */
  public $menuID = "menu";

  /**
   * The speed of the animation 1 is slower
   * @var integer
   */
  private $_delay = 6;

  /**
   * The html output of the widget
   * @var String
   */
  private $_html;
  /**
   * The assets url
   * @var String
   */
  private $_baseUrl;


  /**
   * Gets the html output of the widget
   * @return String
   */
  public function getHtml() {
    return $this->_html;
  }

  /**
   * Sets the menu data
   * @param array $menu
   *
   */
  public function setMenu($menu) {
    if(is_array($menu)) {
      $this->_menu = $menu;
    } else {
      throw new CException("Menu must be an array");
    }
  }

  /**
   * Sets the delay of the animation
   * @param int $delay
   */
  public function setDelay($delay) {
  //speed 1 has an issue so don't use it
    $delay = $delay ==1 ? 2 : $delay;
    if(is_integer($delay)) {
      if($delay > 0) {
        $this->_delay = $delay;
      }
    }
  }

  /**
   * Execute the widget
   */
  public function run() {
    if(!isset ($this->_menu) || $this->_menu == array()) {
      throw new CException("Menu is not set or it's empty");
    }
    $this->registerClientScripts();
    $this->createMarkup();
  }

  /**
   * Registers the clientside widget files (css & js)
   */
  public function registerClientScripts() {
  //Yii::app()->clientScript->registerCoreScript('jquery');
  // Get the resources path
    $resources = dirname(__FILE__).DIRECTORY_SEPARATOR.'resources';

    // publish the files
    $this->_baseUrl = Yii::app()->assetManager->publish($resources);

    //Debug : publish style in every request
    //Yii::app()->assetManager->publish($resources.'/'.$this->stylesheet);
    //Yii::app()->assetManager->publish($resources.'/menu.js');
    // register the files
    Yii::app()->clientScript->registerScriptFile($this->_baseUrl.'/menu.js');
    Yii::app()->clientScript->registerCssFile($this->_baseUrl.'/'.$this->stylesheet);
  }

  /**
   * Creates the html markup needed by the widget
   */
  public function createMarkUp() {
    $this->_html = "<ul id='".$this->menuID."' class='menu'>\n";
    $this->_createMenu($this->_menu);
    $this->_html .= "</ul>\n";
    $this->_html .= "<script type='text/javascript'>\n";
    $this->_html .= "var ".$this->menuID."=new menu.dd('".$this->menuID."',".$this->_delay.");\n";
    $this->_html .= $this->menuID.".init('".$this->menuID."','menuhover');\n";
    $this->_html .= "</script>\n";

    echo $this->_html;
  }

  /**
   * Creates the menu unordered list
   * @param array $menu : The menu array
   * @param if we're on a sub menu or not $rec
   */
  private function _createMenu($menu,$sub = false) {
    if(is_array($menu)) {
    //CVarDumper::dump($data, 5, true);
    //exit();
      foreach ($menu as $data) {
      // If in top menu set class topline
        if(!$sub) {
          $liClass= "class=topline";
        }
        // If there's a menu item to display
        if($this->_isMenuItem($data)) {
          $label = $data["label"];
          $url = $this->_createUrl($data);
          //if (there are html options get them)
          if(is_array($data['url']['htmlOptions'])) {
            $htmlOptions = $data['url']['htmlOptions'];
          } else {
            $htmlOptions = array();
          }
          if(is_file($data["icon"])) {
            $imUrl = Yii::app()->assetManager->publish($data["icon"]);
            $image = CHtml::image($imUrl,"",array("border"=>0,"style"=>"padding-right:10px;vertical-align:bottom"));
          } else {
            $image = "";
          }
          if (!$this->hasChild($data)) {
            $class = $url=="" ?  "disabled" : "menulink";
            $this->_html .= "<li $style $liClass>";
            $htmlOptions["class"]=$class;
            $this->_html .= CHtml::link($image.$label.$subImage, $url, $htmlOptions);
            $this->_html .= "</li>\n";
          } else {
            if($sub) {
              $class =  "sub" ;
              $subImage = CHtml::image($this->_baseUrl."/images/arrow.gif","",
            array("border"=>0,"class"=>"arrow"));
            } else {
              $class = "menulink";
              $subImage="";
            }
            $class .= $url=="" ?  " disabled" : " menulink";
            $this->_html .= "<li $style $liClass>";
            $htmlOptions["class"]=$class;
            $this->_html .= CHtml::link($image.$label.$subImage, $url, $htmlOptions);
            $this->_html .= "<ul>\n";
            $this->_html .= $this->_createMenu($data,true);
            $this->_html .= "</ul>\n";
          }
        }
      }
    }
  }

  /**
   * Checks if there's a menu item to display
   * $data must be an array with a label key
   * and if the key visible is set it must be true
   * @param array $data
   * @return true if there's a menu item
   */
  private function _isMenuItem($data) {
    if(is_array($data) &&
        $data['label'] &&
        (!isset($data["visible"])
        || !$data["visible"]==false)
    ) {

      return true;
    }
    return false;

  }

  /**
   * Create the url link
   * @param array $data
   */
  private function _createUrl($data) {
  // If url is an array or a non blank string and it's not disabled
    if(($data['url']['route']!= "" || $data['url'] != array()) && !$data["disabled"]) {
    //if url is array create the url
      if(isset($data['url']['route'])) {
      // If there are parameters get them
        if(is_array($data['url']['params'])) {
          $params = $data['url']['params'];
        } else {
          $params = array();
        }
        // Create the url
        $url = $this->controller->createUrl(
            $data['url']['route']
            ,$params);
      } else {
        $url = $data['url']['link'];
      }
    } else {
      $url="";
    }

    return $url;
  }

  /**
   * Checks if this menu array has a submenu
   * @param array $arr
   * @return true if there's a submenu
   */
  private function hasChild($arr) {
    if(!is_array($arr)) {
      return false;
    }
    foreach ($arr as $title=>$value) {
      if(!$title == "url") {
        if(is_array($value)) {
          return true;
        }
      }
    }
    return false;
  }
}
?>
