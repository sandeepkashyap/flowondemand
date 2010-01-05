<?php

class ApplicationController extends Controller
{
	const PAGE_SIZE=10;

	/**
	 * @var string specifies the default action to be 'list'.
	 */
	public $defaultAction='index';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	public function init() {
      	parent::init();
      	$this->application_id = Yii :: app()->getRequest()->getParam('id', 0);
		if ($this->application_id > 0 ) {
			$this->loadapplication($this->application_id);
			if ($this->_model == null || !$this->_model->canAccess(Yii::app()->user)) {
				throw new CHttpException(403, 'Invalid request. You do not have permission to access this application.');
			}
			
		}
//		Yii::app()->wireframe->addBreadCrumb('Applications', $this->createUrl('application/admin'));
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'list' and 'show' actions
				'actions'=>array('list','show'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'index', 'admin'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Shows a particular model.
	 */
	public function actionShow()
	{

		Yii::app()->wireframe->addPageAction('New Application', $this->createUrl('application/create'));
		Yii::app()->wireframe->addPageAction('Edit', $this->createUrl('application/update', array('id' => $this->application_id)));

		$this->application_id = Yii :: app()->getRequest()->getParam('id', 0);

		$app = application::model()->findByPk($this->application_id);
		if ($app) {
			Yii :: app()->wireframe->addBreadCrumb($app->vc_name, $this->createUrl('application/show', array('id'=>$app->id)));
			Yii :: app()->wireframe->addBreadCrumb('Details');
		}

		$this->page_tabs->add('Application',
			array('text' => $app->vc_name,
				'url' => Yii::app()->createUrl('apps/application/show', array('id' => $this->application_id))));
		$this->page_tabs->add('Images',
			array('text' => 'Images',
				'url' => Yii::app()->createUrl('image/image/admin', array('application' => $this->application_id))));
		$this->page_tabs->add('Test',
			array('text' => 'Test',
				'url' => Yii::app()->createUrl('image/image/test', array('application' => $this->application_id))));
		$this->page_tabs->add('Log',
			array('text' => 'Log',
				'url' => Yii::app()->createUrl('image/image/log', array('application' => $this->application_id))));

		$this->page_tab = 'Application';
		$this->render('show',array('model'=>$this->loadapplication()));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionCreate()
	{
		Yii::app()->wireframe->addBreadCrumb('Create Application');

		$model=new application;
		$model->int_size = 50000;
		$model->int_nbanwsers = 1;
		$model->float_scoremin = 0.25;
		$model->int_tokens = 0;
		$model->int_teches = 0;
		$model->nm_sens = 0;
		 
		if(isset($_POST['application']))
		{
			$model->attributes=$_POST['application'];
			$model->id_client = Yii::app()->user->id;
			if($model->save()) {
				if (Yii::app()->request->getIsAjaxRequest()) {
					echo CJSON::encode(array('success' => true, 'isNew' => true, 'model' => $model));
					exit;
				} else {
					$this->redirect(array('show','id'=>$model->id));					
				}
			} else {
				if (Yii::app()->request->getIsAjaxRequest()) {
					echo CJSON::encode(array('success' => false, 'errors' => Html::errorSummary($model)));
					exit;
				}
			}
		}
		$this->render('create',array('model'=>$model));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadapplication();
		Yii :: app()->wireframe->addBreadCrumb($model->vc_name, $this->createUrl('application/show', array('id'=>$model->id)));
		Yii :: app()->wireframe->addBreadCrumb('Edit');
		if(isset($_POST['application']))
		{
			$model->attributes=$_POST['application'];
			if($model->save()) {
				if (Yii::app()->request->getIsAjaxRequest()) {
					echo CJSON::encode(array('success' => true, 'isNew' => false, 'model' => $model));
					exit;
				} else {
					$this->redirect(array('show','id'=>$model->id));					
				}
			} else {
				if (Yii::app()->request->getIsAjaxRequest()) {
					echo CJSON::encode(array('success' => false, 'errors' => Html::errorSummary($model)));
					exit;
				}
			}
		}
		$this->render('update',array('model'=>$model));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'list' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadapplication()->delete();
			$this->redirect(array('list'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionList()
	{
		Yii::app()->wireframe->addBreadCrumb('List');

		Yii::app()->wireframe->addPageAction('New Application', $this->createUrl('application/create'));

		$criteria=new CDbCriteria;
		$criteria->condition = "id_client = " . Yii::app()->user->id . " OR " . Yii::app()->user->rank . " >=4";
		$criteria->order = "vc_name ASC";
		
		$pageSize = isset($_REQUEST['items_per_page']) && $_REQUEST['items_per_page'] ? $_REQUEST['items_per_page'] : self :: PAGE_SIZE;
		
		if (isset($_REQUEST['start']) && intval($_REQUEST['start']) > 0) {
			$_GET['page'] = $_REQUEST['start']  / $pageSize + 1;
		}

		$pages=new CPagination(application::model()->count($criteria));
		$pages->pageSize=$pageSize;
		$pages->applyLimit($criteria);

		$models=application::model()->findAll($criteria);

		if (isset($_REQUEST['format']) && $_REQUEST['format'] == 'json') {
			header('Content-Type: text/json');
			$this->renderPartial('getPageJson', array (
				'models' => $models,
				'pages' => $pages,
				'sort' => $sort,
	
			));			
			
		} else {
			$this->render('list',array(
				'models'=>$models,
				'pages'=>$pages,
			));			
		}
		die();		
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		Yii::app()->wireframe->addBreadCrumb('List');

		Yii::app()->wireframe->addPageAction('New Application', $this->createUrl('application/create'));

		$this->processAdminCommand();

		$criteria=new CDbCriteria;

		$pages=new CPagination(application::model()->count($criteria));
		$pages->pageSize=self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$sort=new CSort('application');
		$sort->applyOrder($criteria);

		$models=application::model()->findAll($criteria);

		$this->render('admin',array(
			'models'=>$models,
			'pages'=>$pages,
			'sort'=>$sort,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadapplication($id=null)
	{
		if($this->_model===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_model=application::model()->findbyPk($id!==null ? $id : $_GET['id']);
//			if($this->_model===null)
//				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

	/**
	 * Executes any command triggered on the admin page.
	 */
	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$this->loadapplication($_POST['id'])->delete();
			// reload the current page to avoid duplicated delete actions
			$this->refresh();
		}
	}

	public function actionIndex() {
		
		$criteria = new CDbCriteria;		
		$criteria->condition = "id_client = " . Yii::app()->user->id . " OR " . Yii::app()->user->rank . " >=4";
		$criteria->order = "vc_name ASC";		
		
		Yii::app()->wireframe->addBreadCrumb('Select an application');		
		Yii::app()->wireframe->addPageAction('New Application', $this->createUrl('application/create'));
		Yii::app()->clientScript->registerScript('App.data.application_image_url', 'App.data.application_image_url=' . CJSON::encode(Yii::app()->createUrl('image/image/admin/application/')), 4);
		
		//$models = application::model()->findAllBySql("SELECT a.* FROM apps a WHERE a.id_client = " . Yii::app()->user->id . " OR " . Yii::app()->user->rank . " >=4 ORDER BY vc_name ASC");
		//fb("SELECT a.* FROM apps a WHERE a.id_client = " . Yii::app()->user->id . " OR " . Yii::app()->user->rank . " >=4 ORDER BY vc_name");
		if (application::model()->count($criteria) == 1) {
			$this->redirect(Yii::app()->createUrl('image/image/admin/', array('application' => $models[0]->id)));
			exit;
		}
		else{
			$models = application::model()->findAll($criteria);
			$this->render('index', array('models' => $models));
		}		
	}

}
