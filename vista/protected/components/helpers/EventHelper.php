<?php
class EventHelper {
	
	public function raiseModuleEvent($name, &$event) {
		foreach(Yii::app()->modules as $moduleName => $config) {
			$m = Yii::app()->getModule($moduleName);
			if (method_exists($m, $name)) {
				$m->$name(&$event);
			}
		}
	}
}
?>
