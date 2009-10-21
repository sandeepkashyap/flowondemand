<?php
class UserPostController extends Controller {
	
	public function actionIndex() {
		
		$module_name = $this->getModule()->getId();
		$controller_name = $this->getId();
		$action_name = $this->getAction()->getId();
		echo 
			"if(App.{$module_name} && App.{$module_name}.controllers.{$controller_name}) {
        		if(typeof(App.{$module_name}.controllers.{$controller_name}.{$action_name}) == 'function') {
          			App.{$module_name}.controllers.{$controller_name}.{$action_name}();
        		}
			}";
	
	}
	public function actionAdd() {
		echo '=====================';
$name=ucfirst(basename($this->getId()));
if($this->getAction()!==null && strcasecmp($this->getAction()->getId(),$this->defaultAction))
	echo $name . '.' . ucfirst($this->getAction()->getId());
else
	echo Yii::app()->name.' - '.$name;
echo '=====================';
	}
}
?>
	