<?php
Yii :: import('apps.models.*');


class TestController extends Controller {
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

	public function init() {
		parent :: init();
		$this->application_id = Yii :: app()->getRequest()->getQuery('application', 0);

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
					'list',
					'show',
					'log'
				),
				'users' => array (
					'@'
				),

			),
			array (
				'allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions' => array (
					'admin',
					'create',
					'update',
					'quickAdd',
					'quickUpdate',
					'changeImage',
					'viewFull',
					'undoTrash',
					'getPage'
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

			),
			array (
				'deny', // deny all users
				'users' => array (
					'*'
				),

			),

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
			echo '<p id="success" class="flash"><span class="flash_inner">The image ['. $model->vc_name .'] has been moved to the Trash. <a class="undo_link" rel="'.$model->id_image.'">Undo</a></span></p>';
		} else {
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionList() {
		Yii :: app()->wireframe->addBreadCrumb(Yii :: t('application', 'List'));

		Yii :: app()->wireframe->addPageAction(Yii :: t('application', 'New') . '', $this->createUrl('image/create'));

		$criteria = new CDbCriteria;

		$pages = new CPagination(Image :: model()->count($criteria));
		$pages->pageSize = self :: PAGE_SIZE;
		$pages->applyLimit($criteria);

		$models = Image :: model()->findAll($criteria);

		$this->render('list', array (
			'models' => $models,
			'pages' => $pages,

		));
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

		$pages = new CPagination(Image :: model()->count($criteria));
		$pages->pageSize = self :: PAGE_SIZE;
		$pages->applyLimit($criteria);

		$sort = new CSort('Image');
		$sort->applyOrder($criteria);

		$models = Image :: model()->findAll($criteria);

		Yii :: app()->clientScript->registerScript('App.data.image_undo_trash_url', 'App.data.image_undo_trash_url=' . CJSON :: encode($this->createUrl('image/undoTrash')), 4);
		Yii :: app()->clientScript->registerScript('App.data.image_change_url', 'App.data.image_change_url=' . CJSON :: encode($this->createUrl('image/changeImage')), 4);
		Yii :: app()->clientScript->registerScript('App.data.image_slide_show', 'App.data.image_full_url=' . CJSON :: encode($this->createUrl('image/viewFull')), 4);
		Yii :: app()->clientScript->registerScript('App.data.image_full_url', 'App.data.image_full_url=' . CJSON :: encode($this->createUrl('image/viewFull')), 4);
		Yii :: app()->clientScript->registerScript('App.data.image_quick_update_url', 'App.data.image_quick_update_url=' . CJSON :: encode($this->createUrl('image/quickUpdate')), 4);
		Yii :: app()->clientScript->registerScript('App.data.image_ajax_page', 'App.data.image_ajax_page=' . CJSON :: encode($this->createUrl('image/getPage', array('application' => $this->application_id))), 4);
		Yii :: app()->clientScript->registerScript('App.data.image_total', 'App.data.image_total='.$pages->getItemCount());
		Yii :: app()->clientScript->registerScript('App.data.application_combobox_data', 'App.data.application_combobox_data=\'' . CJSON :: encode(CHtml :: listData(application :: model()->findAll(), 'id', 'vc_name')) . '\'', 4);

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
				$contents = file_get_contents($from_url); //fetch RSS feed

				$fp=fopen($full_path, "w");
				fwrite($fp, $contents); //write contents of feed to cache file
				fclose($fp);
			}

			//create thumbnail
			if ($file_name) {
				$thumbnail_folder = Yii::app()->getModule('image')->thumbnails_folder;
				$thumbail_file = $thumbnail_folder . $file_name . ".jpg";
				if (SThumbnail::scale_image($full_path, $thumbail_file, 100, 100)) {
				} else {
				}
			}

			$model->attributes = $_POST['Image'];
			$model->vc_image = $file_name;
			$model->id_application = $this->application_id;
			if (!$model->save()) {
				die('<table style="display:none"><tr><td>co loi rui</td></tr></table>');
			}
		} else {
		}
		$this->renderPartial('quickAdd', array (
			'model' => $model
		));
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
			$contents = file_get_contents($from_url); //fetch RSS feed

			$fp=fopen($full_path, "w");
			fwrite($fp, $contents); //write contents of feed to cache file
			fclose($fp);

		}

		if ($file_name) {
			$thumbnail_folder = Yii::app()->getModule('image')->thumbnails_folder;
			$thumbail_file = $thumbnail_folder . $file_name . ".jpg";
			if (SThumbnail::scale_image($full_path, $thumbail_file, 100, 100)) {
			} else {
			}
		} else {
			$model->$key = $_POST['value'];
		}

		if ($model->save()) {
			switch ($key) {
				case 'id_application' :
					die($model->application->vc_name);
					break;
				case 'vc_image' :
					echo Yii::app()->createUrl("/site/thumbnail/image/$model->vc_image", array('rand'=>time()));
					exit;
				default :
					die($model->$key);
					break;
			}
		} else {
			die('something wrong...');
		}
	}

	public function actionTest() {
		$this->page_tab = 'Test';
		$this->render('test');
	}

	public function actionLog() {
		$this->page_tab = 'Log';
		$this->render('log');
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

		$pages = new CPagination(Image :: model()->count($criteria));
		$pages->pageSize = self :: PAGE_SIZE;
		$pages->applyLimit($criteria);

		$sort = new CSort('Image');
		$sort->applyOrder($criteria);

		$models = Image :: model()->findAll($criteria);

		$this->renderPartial('getPage', array (
			'models' => $models,
			'pages' => $pages,
			'sort' => $sort,

		));
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
		$this->renderPartial('quickAdd', array(
			'model' => $model
		));
		die();
	}

	public function actionSlideShow() {
		list ($key, $id) = explode(':', isset($_POST['id']) ? $_POST['id'] : $_GET['id']);
		$model = $this->loadImage($id);
		echo "<img src='' alt='{$model->vc_name}'/>";
		die();
	}
	
	public function actionViewFull() {
		$id = isset($_POST['id']) ? $_POST['id'] : $_GET['id'];
		$model = $this->loadImage($id);
		$images_folder = Yii::app()->getModule('image')->images_folder;
		
		$image = $images_folder . $model->vc_image;
		if ($model == null || !file_exists($image)) {
			$image = ASSETS_PATH . 'images/image-load-error.gif';
		}
		header('Content-Type: image/jpeg');
		readfile($image);
		flush();
		exit;
	}
}