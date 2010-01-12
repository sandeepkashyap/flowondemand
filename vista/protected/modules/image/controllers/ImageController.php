<?php

function helloError($errNo, $errStr, $errFile, $errLine, $errContext) {
	Yii::log("==============Error================");
	Yii::log("errNo: $errNo");
	Yii::log("errStr: $errStr");
	Yii::log("errFile: $errFile");
	Yii::log("errLine: $errLine");
	Yii::log("errContext: $errContext");
	Yii::log("===================================");
	//throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
}

function resizeImageError($errNo, $errStr, $errFile, $errLine, $errContext) {
	Yii::log("==============Error================");
	Yii::log("errNo: $errNo");
	Yii::log("errStr: $errStr");
	Yii::log("errFile: $errFile");
	Yii::log("errLine: $errLine");
	Yii::log("errContext: $errContext");
	Yii::log("===================================");
	throw new CHttpException(400, "The application's max picture size (int_size) is too small!");
}

Yii :: import('apps.models.*');


class ImageController extends Controller {
	const PAGE_SIZE = 10;

	/**
	 * @var string specifies the default action to be 'list'.
	 */
	public $defaultAction = 'admin';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	public $application_id = 0;
	
	public $skip_layout = 0;

	public function init() {
		parent :: init();
		if (isset($_POST['application_id'])) {
			$this->application_id = $_POST['application_id'];
		} else {
			$this->application_id = Yii :: app()->getRequest()->getQuery('application', 0);
		}
		
		$this->skip_layout = Yii :: app()->getRequest()->getQuery('skip_layout', 0);

		$app = application::model()->findByPk($this->application_id);
		if ($app) {
			Yii :: app()->wireframe->addBreadCrumb($app->vc_name, Yii::app()->createUrl('apps/application/show', array('id' => $this->application_id)));
		}
		Yii :: app()->wireframe->addBreadCrumb('Images', $this->createUrl('image/admin', array('application' => $this->application_id)));

		Yii :: app()->clientScript->registerScript('App.data.image_delete_url', 'App.data.image_delete_url=' . CJSON :: encode($this->createUrl('image/delete')), 4);
	}

	/**
	 * @return array action filters
	 */
	public function filters() {
		return array (
			'accessControl', // perform access control for CRUD operations

		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() {
		return array (
			array (
				'allow', // allow all users to perform 'list' and 'show' actions
				'actions' => array (
					'batchIndex',
					'show',
					'test'
				),
				'users' => array (
					'@'
				),

			),
			array (
				'denied', // allow authenticated user to perform 'create' and 'update' actions
				'actions' => array (
					'admin',
					'list',
					'create',
					'update',
					'quickAdd',
					'quickUpdate',
					'changeImage',
					'viewFull',
					'undoTrash',
					'csvForm',
					'iframe',
					'updateImageSize',
					'updateIndexed',
					'manualIndex',
					'getPage',
					'print',
					'log'
				),
				'users' => array (
					'?'
				),

			),
			array (
				'allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions' => array (
					'admin',
					'list',
					'create',
					'update',
					'quickAdd',
					'quickUpdate',
					'changeImage',
					'viewFull',
					'undoTrash',
					'csvForm',
					'iframe',
					'updateImageSize',
					'updateIndexed',
					'manualIndex',
					'getPage',
					'print',
					'log'
				),
				'users' => array (
					'@'
				),

			),
			array (
				'allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions' => array (
					'admin',
					'delete',
					'test'
				),
				'users' => array (
					'admin'
				),

			)			

		);
	}

	/**
	 * Shows a particular model.
	 */
	public function actionShow() {
		Yii :: app()->wireframe->addBreadCrumb(Yii :: t('application', 'View'));

		Yii :: app()->wireframe->addPageAction(Yii :: t('application', 'New') . '', $this->createUrl('image/create'));

		$model = $this->loadImage();

		//		$images_folder = Yii::app()->getModule('image')->images_folder;
		//		$thumbnail_folder = Yii::app()->getModule('image')->thumbnails_folder;
		//
		//		$thumbnail = new SThumbnail($images_folder . $model->vc_image, $thumbnail_folder . $model->vc_image . ".jpg", 100);
		//		$thumbnail->createthumb();

		$this->render('show', array (
			'model' => $model
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionCreate() {
		Yii :: app()->wireframe->addBreadCrumb(Yii :: t('application', 'Create'));

		$model = new Image;

		$images_folder = Yii :: app()->getModule('image')->images_folder;

		$file = CUploadedFile :: getInstance($model, 'vc_image');
		$file_name = null;
		if ($file) {
			$file_name = rand(1000, 9999) . '-' . rand(1000, 9999) . '-' . rand(1000, 9999) . '-' . rand(1000, 9999) . '-' . rand(1000, 9999);
			$file->saveAs($images_folder . $file_name);
		}

		if (isset ($_POST['Image'])) {
			$model->attributes = $_POST['Image'];
			$model->vc_image = $file_name;
			$model->id_application = $this->application_id;
			if ($model->save())
				$this->redirect(array (
					'show',
					'id' => $model->id_image
				));
		}
		$this->render('create', array (
			'model' => $model
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionUpdate() {
		Yii :: app()->wireframe->addBreadCrumb(Yii :: t('application', 'Edit'));

		$model = $this->loadImage();
		if (isset ($_POST['Image'])) {
			$model->attributes = $_POST['Image'];
			if ($model->save())
				$this->redirect(array (
					'show',
					'id' => $model->id_image
				));
		}
		$this->render('update', array (
			'model' => $model
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'list' page.
	 */
	public function actionDelete() {
		if (Yii :: app()->request->isPostRequest) {
			$model = $this->loadImage($_POST['image_id']);
			// we only allow deletion via POST request
			$model->moveTrash();
			echo '<p id="success" class="flash"><span class="flash_inner">The image ['. $model->vc_name .'] has been moved to the Trash. <a class=" x-btn-text undo_link" rel="'.$model->id_image.'">Undo</a></span></p>';
		} else {
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionList() {
		$this->layout = 'application.views.layouts.desktop';
		
		$this->render('list');
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin() {
		Yii :: app()->wireframe->addBreadCrumb(Yii :: t('application', 'All images'));

//		Yii :: app()->wireframe->addPageAction(Yii :: t('application', 'New') . '', $this->createUrl('image/create', array('application'=>$this->application_id)));
		$this->processAdminCommand();

		$criteria = new CDbCriteria;
		$criteria->condition = "is_trash < 1 && id_application = $this->application_id";
		$criteria->order = " id_image DESC";
		

		$pages = new CPagination(Image :: model()->count($criteria));
		$pages->pageSize = isset($_GET['items_per_page']) && $_GET['items_per_page'] ? $_GET['items_per_page'] : self :: PAGE_SIZE;
		$pages->applyLimit($criteria);

		$sort = new CSort('Image');
		$sort->applyOrder($criteria);

		$models = Image :: model()->findAll($criteria);

		Yii :: app()->clientScript->registerScript('App.data.image_undo_trash_url', 'App.data.image_undo_trash_url=' . CJSON :: encode($this->createUrl('image/undoTrash')), 4);
		Yii :: app()->clientScript->registerScript('App.data.image_csv_url', 'App.data.image_csv_url=' . CJSON :: encode($this->createUrl('image/csvForm', array('application'=>$this->application_id))), 4);
		Yii :: app()->clientScript->registerScript('App.data.image_change_url', 'App.data.image_change_url=' . CJSON :: encode($this->createUrl('image/changeImage')), 4);
		Yii :: app()->clientScript->registerScript('App.data.image_slide_show', 'App.data.image_full_url=' . CJSON :: encode($this->createUrl('image/viewFull')), 4);
		Yii :: app()->clientScript->registerScript('App.data.image_full_url', 'App.data.image_full_url=' . CJSON :: encode($this->createUrl('image/viewFull')), 4);
		Yii :: app()->clientScript->registerScript('App.data.image_manual_index_url', 'App.data.image_manual_index_url=' . CJSON :: encode($this->createUrl('image/manualIndex')), 4);
		Yii :: app()->clientScript->registerScript('App.data.image_quick_update_url', 'App.data.image_quick_update_url=' . CJSON :: encode($this->createUrl('image/quickUpdate')), 4);
		Yii :: app()->clientScript->registerScript('App.data.image_tiled_url', 'App.data.image_tiled_url=' . CJSON :: encode($this->createUrl('image/list', array('application'=>$this->application_id))), 4);
		Yii :: app()->clientScript->registerScript('App.data.image_admin_url', 'App.data.image_admin_url=' . CJSON :: encode($this->createUrl('image/getPage', array('application'=>$this->application_id))), 4);
		Yii :: app()->clientScript->registerScript('App.data.image_print_url', 'App.data.image_print_url=' . CJSON :: encode($this->createUrl('image/print', array('application'=>$this->application_id))), 4);
		Yii :: app()->clientScript->registerScript('App.data.image_ajax_page', 'App.data.image_ajax_page=' . CJSON :: encode($this->createUrl('image/getPage', array('application' => $this->application_id))), 4);
		Yii :: app()->clientScript->registerScript('App.data.image_total', 'App.data.image_total='.$pages->getItemCount());
		Yii :: app()->clientScript->registerScript('App.data.application_combobox_data', 'App.data.application_combobox_data=\'' . CJSON :: encode(CHtml :: listData(application :: model()->findAll(), 'id', 'vc_name')) . '\'', 4);
		Yii :: app()->clientScript->registerScript('image_csv_upload_success', 'image_csv_upload_success=0', 4);

		$this->render('admin', array (
			'models' => $models,
			'pages' => $pages,
			'sort' => $sort,

		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadImage($id = null) {
		if ($this->_model === null) {
			if ($id !== null || isset ($_GET['id']))
				$this->_model = Image :: model()->findbyPk($id !== null ? $id : $_GET['id']);
//			if ($this->_model === null)
//				throw new CHttpException(404, 'The requested page does not exist.');
		}
		return $this->_model;
	}

	/**
	 * Executes any command triggered on the admin page.
	 */
	protected function processAdminCommand() {
		if (isset ($_POST['command'], $_POST['id']) && $_POST['command'] === 'delete') {
			$this->loadImage($_POST['id'])->delete();
			// reload the current page to avoid duplicated delete actions
			$this->refresh();
		}
	}

	public function actionQuickAdd() {
		//set_error_handler(resizeImageError);
		$model = new Image;
		if (isset ($_POST['Image'])) {
			$images_folder = Yii :: app()->getModule('image')->images_folder;

			$file = CUploadedFile :: getInstance($model, 'vc_image');
			$file_name = null;

			if ($file) {
				$file_name = rand(1000, 9999) . '-' . rand(1000, 9999) . '-' . rand(1000, 9999) . '-' . rand(1000, 9999) . '-' . rand(1000, 9999);
				$full_path = $images_folder . $file_name;
				if ($file->saveAs($full_path)) {
				} else {
				}
			} else if (isset($_POST['Image']['from_url'])) {
				$file_name = rand(1000, 9999) . '-' . rand(1000, 9999) . '-' . rand(1000, 9999) . '-' . rand(1000, 9999) . '-' . rand(1000, 9999);
				$full_path = $images_folder . $file_name;

				$from_url = $_POST['Image']['from_url'];
				$contents = $this->wgetImage($from_url); //fetch RSS feed

				$fp=fopen($full_path, "w");
				fwrite($fp, $contents); //write contents of feed to cache file
				fclose($fp);
			}
			

			//resize image
//			$application = application::model()->findByPk($this->application_id);
//			
//			if (intval($application->int_size) < 100) {
//				throw new CHttpException(400, "The application's max picture size (int_size) is too small!");
//			}
			
//			$arr = SThumbnail::getImageSize($full_path);
//			$isImage = is_array($arr);
//			if ($isImage && SThumbnail::resize_image($full_path, $full_path . '_rz', $application->int_size)) {
//				unlink($full_path);
//				rename($full_path . '_rz', $full_path);
//			}
			// image has been resize, so need to get image size
			$arr = SThumbnail::getImageSize($full_path);
			$isImage = is_array($arr);
			
			if ($isImage && $file_name) {
				$thumbnail_folder = Yii::app()->getModule('image')->thumbnails_folder;
				$thumbail_file = $thumbnail_folder . $file_name . ".jpg";
				if (SThumbnail::scale_image($full_path, $thumbail_file, 100, 100)) {
				} else {
				}
			}

			$model->attributes = $_POST['Image'];
			$model->vc_image = $file_name;
			$model->id_application = $this->application_id;
			if ($isImage) {
				$model->int_width = $arr[0]; 
				$model->int_height = $arr[1]; 				
			}			
			if (!$isImage || !$model->save()) {
				throw new CHttpException(500, "May be url uploaded file is invalid image or url is invalid. Please try again!");
			}
			$this->_imageIndex($model, false);
		} else {
		}
		if (isset($_REQUEST['format']) && $_REQUEST['format'] == 'json') {
			$retval = array(
				'id_image' => $model->id_image,
	    		'vc_image' => $model->vc_image,
	    		'vc_name' => $model->vc_name,
	    		'vc_url' => $model->vc_url,
	    		'dt_created' => $model->dt_received ? $model->dt_received : '',
	    		'dt_indexed' => $model->dt_indexed ? $model->dt_indexed : '',
				'int_width' => $model->int_width,        		 
				'int_height' => $model->int_height,        		 
			);
			echo "{success: true, model: ". CJSON::encode($retval) ."}";						
		} else {
			$this->renderPartial('quickAdd', array (
				'model' => $model
			));
		}
		die();
	}

	public function actionQuickUpdate() {		
		$key = null;
		$id = null;
		list ($key, $id) = explode(':', isset($_POST['id']) ? $_POST['id'] : $_GET['id']);
		$file = null;
		if (count($_FILES)) {
			$file = CUploadedFile::getInstanceByName('value');
		}
		$model = $this->loadImage($id);
//		$application = $model->application;				
//		if (intval($application->int_size) < 100) {
//			fb($this->application_id);
//			fb($application->int_size);
//			throw new CHttpException(400, "The application's max picture size (int_size) is too small!");
//		}
		$file_name = null;
		if ($file) {
			$images_folder = Yii :: app()->getModule('image')->images_folder;
			$file_name = $model->$key;
			$full_path = $images_folder . $file_name;
			$file->saveAs($full_path);

			$thumbnail_folder = Yii::app()->getModule('image')->thumbnails_folder;
			if (file_exists($thumbnail_folder . $file_name . '.jpg')) {
				unlink($thumbnail_folder . $file_name . '.jpg');
			}
		} else if (isset($_POST['Image']['from_url'])) {
			$thumbnail_folder = Yii::app()->getModule('image')->thumbnails_folder;
			if (file_exists($thumbnail_folder . $file_name . '.jpg')) {
				unlink($thumbnail_folder . $file_name . '.jpg');
			}
			$images_folder = Yii :: app()->getModule('image')->images_folder;
			$file_name = $model->$key;
			$full_path = $images_folder . $file_name;

			$from_url = $_POST['Image']['from_url'];
			$contents = $this->wgetImage($from_url); //fetch RSS feed

			$fp=fopen($full_path, "w");
			fwrite($fp, $contents); //write contents of feed to cache file
			fclose($fp);

		}

		$isImage = true; //always true for other update case as name, url...
		if ($file_name) {
			//resize image
			$max_size = 200;
			if ($this->application_id) {
				$application = application::model()->findByPk($this->application_id);
			} else {
				$application = application::model()->findByPk($model->id_application);
				$max_size = $application->int_size;				
			}
			
//			$arr = SThumbnail::getImageSize($full_path);
//			$isImage = is_array($arr);
//			
//			if ($isImage && SThumbnail::resize_image($full_path, $full_path . '_rz', $max_size)) {
//				unlink($full_path);
//				rename($full_path . '_rz', $full_path);
//			} else {
//				
//			}
			
			$arr = SThumbnail::getImageSize($full_path);
			$isImage = is_array($arr);
			
			$thumbnail_folder = Yii::app()->getModule('image')->thumbnails_folder;
			$thumbail_file = $thumbnail_folder . $file_name . ".jpg";
			if ($isImage && SThumbnail::scale_image($full_path, $thumbail_file, 100, 100)) {
			} else {
			}
			
			if ($isImage) {
				$model->int_width = $arr[0]; 
				$model->int_height = $arr[1]; 				
			}
			$isSave = $model->save();
//			fb("isImage: $isImage");
//			fb("isSave: $isSave");
			if ($isImage && $isSave) {
				$this->_imageIndex($model);
				echo CJSON::encode(array(
					'success' => 'true',
					'thumbnail' => $model->vc_image . '?rand=' . time(),
					'src' => Yii::app()->createUrl("/site/thumbnail/image/$model->vc_image", array('rand'=>time())),
					'width' => $model->int_width, 
					'height' => $model->int_height, 
					'full_url' => Yii::app()->createUrl('image/image/viewFull', array('id'=>$model->id_image, 'rand'=>time().'.jpg'))
				));					
				exit;
			} else {
				throw new CHttpException(500, "May be url uploaded file is invalid image or url is invalid. Please try again!");
			}
		} else {
			$model->$key = $_POST['value'];
		}
		if ($model->save()) {
			switch ($key) {
				case 'id_application' :
					die($model->application->vc_name);
					break;
				default :
					die($model->$key);
					break;
			}
		} else {
			$errMsg = '';
			
				foreach($model->getErrors() as $errors)
				{
					foreach($errors as $error)
					{
						$errMsg .= "$error ";
					}
				}
			throw new CHttpException(500, $errMsg);
		}
	}

	public function actionLog() {
		
		$criteria = new CDbCriteria;
		$criteria->join = "inner join `index` on index.id_image = index_log.id_image";
		$criteria->condition = "index.id_application = $this->application_id";
		$criteria->order = " index_log.id DESC";

		$pages = new CPagination(IndexLog::model()->count($criteria));
		$pages->pageSize = isset($_GET['items_per_page']) && $_GET['items_per_page'] ? $_GET['items_per_page'] : self :: PAGE_SIZE;
		$pages->applyLimit($criteria);

		$models = IndexLog::model()->findAll($criteria);
		
		Yii :: app()->clientScript->registerScript('App.data.log_total', 'App.data.log_total='.$pages->getItemCount());
		Yii :: app()->clientScript->registerScript('App.data.log_ajax_page', 'App.data.log_ajax_page=' . CJSON :: encode($this->createUrl('image/log', array('application' => $this->application_id))), 4);

		$this->page_tab = 'Log';
		
		$skip_layout = isset($_GET['ajax']) && $_GET['ajax'];
		
		if ($skip_layout) {
			$this->renderPartial('log', array (
				'models' => $models,
				'pages' => $pages,
				'skip_layout' => true
			));
			die();
		} else {
			$this->render('log', array (
				'models' => $models,
				'pages' => $pages,
			));
		}
		
	}

	public function actionGetPage() {
		$criteria = new CDbCriteria;
		$criteria->condition = "is_trash < 1 && id_application = $this->application_id";
		$filter = Yii::app()->getRequest()->getParam('filter');
		switch ($filter) {
			case 'indexed_images':
				$criteria->condition .= ' AND dt_indexed IS NOT NULL';
				break;
			case 'unindexed_images':
				$criteria->condition .= ' AND dt_indexed IS NULL';
				break;
		}
		
		$criteria->order = " id_image DESC";
		
		$pageSize = isset($_REQUEST['items_per_page']) && $_REQUEST['items_per_page'] ? $_REQUEST['items_per_page'] : self :: PAGE_SIZE;
		
		if (isset($_REQUEST['start']) && intval($_REQUEST['start']) > 0) {
			$_GET['page'] = $_REQUEST['start']  / $pageSize + 1;
		}

		$pages = new CPagination(Image :: model()->count($criteria));
		$pages->pageSize = $pageSize;
		$pages->applyLimit($criteria);

		$sort = new CSort('Image');
		$sort->applyOrder($criteria);

		$models = Image :: model()->findAll($criteria);

		if (isset($_REQUEST['format']) && $_REQUEST['format'] == 'json') {
			header('Content-Type: text/json');
			$this->renderPartial('getPageJson', array (
				'models' => $models,
				'pages' => $pages,
				'sort' => $sort,
	
			));			
		} else {
			$this->renderPartial('getPage', array (
				'models' => $models,
				'pages' => $pages,
				'sort' => $sort,
	
			));			
		}
		
		die();
	}

	public function actionChangeImage() {
		list ($key, $id) = explode(':', isset($_POST['id']) ? $_POST['id'] : $_GET['id']);
		$model = $this->loadImage($id);
		$this->renderPartial('changeImage', array (
			'model' => $model
		));
		die();
	}

	public function actionUndoTrash() {
		$model = $this->loadImage();
		$model->undoTrash();
		if (isset($_GET['format']) && $_GET['format'] == 'json') {
			$retval = array(
				'id_image' => $model->id_image,
	    		'vc_image' => $model->vc_image,
	    		'vc_name' => $model->vc_name,
	    		'vc_url' => $model->vc_url,
	    		'dt_created' => $model->dt_received ? $model->dt_received : '',
	    		'dt_indexed' => $model->dt_indexed ? $model->dt_indexed : '',
				'int_width' => $model->int_width,        		 
				'int_height' => $model->int_height,        		 
			); 
			echo CJSON::encode(array('success' => true, 'model' => $retval));
			exit;
		} else {
			$this->renderPartial('quickAdd', array(
				'model' => $model
			));
			
		}
		die();
	}

	public function actionSlideShow() {
		list ($key, $id) = explode(':', isset($_POST['id']) ? $_POST['id'] : $_GET['id']);
		$model = $this->loadImage($id);
		echo "<img src='' alt='{$model->vc_name}'/>";
		die();
	}
	
	public function actionCsvForm() {
//		$application = application::model()->findByPk($this->application_id);
//		if (intval($application->int_size) < 100) {
//			throw new CHttpException(400, "The application's max picture size (int_size) is too small!");
//		}
		$this->layout = 'application.views.layouts.application';
		if (Yii :: app()->request->isPostRequest) {
			$images_folder = Yii :: app()->getModule('image')->images_folder;
			
			$handle = fopen($_FILES['csv_file']['tmp_name'], "r");
			$delimiter = $_POST['delimiter'];
			if ($delimiter == 'custom') {
				$delimiter = $_POST['delimiter_text'];
			} else if ($delimiter == 'tab') {
				$delimiter = "\t";
			}
			$arr = array();
			ini_set('max_execution_time', 0);
			ini_set('memory_limit', '256M');
			$success = 0;
			$count = 1;
			while (($data = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {				
				echo "{$count}. Processing: " . $data[0] . " ...";
				$count++;
				flush();
				$model = new Image;
	
				$file_name = rand(1000, 9999) . '-' . rand(1000, 9999) . '-' . rand(1000, 9999) . '-' . rand(1000, 9999) . '-' . rand(1000, 9999);
				$full_path = $images_folder . $file_name;

				$from_url = $data[0];
				set_error_handler(helloError);
				try {
					$contents = $this->wgetImage($from_url); 
	
					$fp=fopen($full_path, "w");
					fwrite($fp, $contents); 
					fclose($fp);					
				} catch(Exception $err) {
					echo '<span style="color: red">Failed</span><br/>';
					continue;
				}

				$arr = SThumbnail::getImageSize($full_path);
				$isImage = is_array($arr);

				if ($isImage && SThumbnail::open_image($full_path)) {
					$model->vc_name = $data[1];
					$model->vc_image = $file_name;
					$model->vc_url = $data[2];
					$model->id_application = $this->application_id;
					if ($isImage) {
						$model->int_width = $arr[0]; 
						$model->int_height = $arr[1]; 				
					}
					if ($model->save()) {
						echo '<span style="color: green">Done</span><br/>';
						$success++;
						flush();
					} else {
						echo '<span style="color: red">Failed</span><br/>';
					}
					
				} else {
					echo '<span style="color: red">Failed</span><br/>';
				}
	
			}
			fclose($handle);
			echo 'Finished!<br/>';
			if ($success > 0) {
				echo "<script>parent.image_csv_upload_success=$success; window.parent.Ext.getCmp('imagesGrid').getStore().load()</script>";
			}
			return;
		}
		$this->layout = 'application.views.layouts.application';
		$this->render('csvForm');
	}
	
	public function actionViewFull() {
		$id = isset($_POST['id']) ? $_POST['id'] : $_GET['id'];
		$model = $this->loadImage($id);
		$images_folder = Yii::app()->getModule('image')->images_folder;
		
		$image = $images_folder . $model->vc_image;
		if ($model == null || !file_exists($image)) {
			$image = ASSETS_PATH . 'images/image-load-error.gif';
		}
		header('Content-Type: image/jpg');
		
		$handle = fopen($image, 'r');
		while (!feof($handle))
		{
			$data = fgets($handle, 256);
			print $data;
			flush();
		}
		fclose($handle);
		exit;
	}
	
	public function actionUpdateImageSize() {
		$images_folder = Yii :: app()->getModule('image')->images_folder;
		
		$all = Image::model()->findAll();
		foreach($all as $model) {
			$full_path = $images_folder . $model->vc_image;
			if (!file_exists($full_path)) {
				continue;
			}
			$arr = SThumbnail::getImageSize($full_path);
			if (is_array($arr)) {
				$model->int_width = $arr[0]; 
				$model->int_height = $arr[1];
				$model->save();
				echo '<pre>===========' . $model->id_image; print_r($arr); echo '------------</pre>';
				echo 'Done'; 				
			}
		}
	}
	
	public function actionUpdateIndexed() {
		$id = Yii :: app()->getRequest()->getQuery('id', 0);
		$model = $this->loadImage($id);
		if ($model) {
			$model->dt_indexed = date('Y-m-d H:i:s');
			if ($model->save()) {
				echo 'Done';
			} else {
				throw new CHttpException(400, 'Error when update indexed');				
			}
		}
		else {
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
		}
	}
	
	public function actionBatchIndex() {
		$models = Image::model()->getUnIndexed();		
		foreach($models as $m) {
//			echo $m->is_trash . '  ' . $m->id_image . '<br/>';continue;
			$this->_imageIndex($m);
			flush();
		}
	}
	
	private function _imageIndex($model, $verbose = false) {
		$app_size = $model->application->int_size;
		$s = "";
		if ($app_size < ($model->int_width * $model->int_height)) {
			$s = "&s=$app_size";
		}
		$url = "http://find.pic2.eu/in/?r={$model->application->vc_repository}&i=" . ROOT_URL ."/uploads/{$model->vc_image}$s";
		//fb("Image index url: " . $url);
		if ($verbose) {
			echo  $url . '<br/>';			
		}
		
		$result = strip_tags(file_get_contents($url), "<b>");
		$iResult = intval($result);
		
		if ($verbose) {
			echo $iResult . ' = ' . $result . '<br/>';
		}			
		
		//log indexing result
		$log = new IndexLog();
		$log->id_image = $model->id_image;
		$log->vc_result = $result;
		$log->int_keypoint = $iResult > 0 ? $iResult : -1;		
		$log->save();
		
		$model->int_keypoint = $iResult > 0 ? $iResult : -1;
		//only update dt_indexed if keypoint > 0
		if ($model->int_keypoint > 0) {
			$model->dt_indexed = date('Y-m-d H:i:s');			
		}
		$model->save();
	}
	
	public function actionManualIndex() {
		$model = $this->loadImage();
		$this->_imageIndex($model);
		list($indicator, $message) = $model->getIndicator();
		echo CJSON::encode(array(
			'indicator' => $indicator,
			'message' => $message ? $message : '',
			'dt_indexed' => $model->dt_indexed ? $model->dt_indexed : ''
		));
		die();
	}
	
	public function actionTest() {
		$this->page_tab = 'Test';
		$this->render('test');
	}
	
	public function actionPrint() {
		$criteria = new CDbCriteria;
		$criteria->condition = "is_trash < 1 && id_application = $this->application_id";
		$filter = Yii::app()->getRequest()->getParam('filter');
		switch ($filter) {
			case 'indexed_images':
				$criteria->condition .= ' AND dt_indexed IS NOT NULL';
				break;
			case 'unindexed_images':
				$criteria->condition .= ' AND dt_indexed IS NULL';
				break;
		}
		
		$criteria->order = " id_image DESC";

		$pages = new CPagination(Image :: model()->count($criteria));
		$pages->pageSize = isset($_GET['items_per_page']) && $_GET['items_per_page'] ? $_GET['items_per_page'] : self :: PAGE_SIZE;
		$pages->applyLimit($criteria);

		$sort = new CSort('Image');
		$sort->applyOrder($criteria);

		$models = Image :: model()->findAll($criteria);

		$this->layout = 'application.views.layouts.print';
		$width = Yii :: app()->getRequest()->getQuery('width', '100px');
		
		$this->render('print', array (
			'models' => $models,
			'width' => $width
		));
	}
	
	private function wgetImage($url) {
		if (!function_exists('curl_init')) {
			return file_get_contents($url);
		}
		//get video content using CURL library
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$content = curl_exec($ch);
		curl_close($ch);
		return $content;
	}
}