<?php

class application extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'application':
	 * @var integer $id_application
	 * @var integer $id_client
	 * @var integer $int_size
	 * @var integer $int_nbanwsers
	 * @var double $float_scoremin
	 * @var integer $int_tokens
	 * @var integer $int_teches
	 * @var string $vc_name
	 * @var string $vc_description
	 * @var string $vc_repository
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'apps';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_client, vc_name, vc_description, int_size, int_nbanwsers, float_scoremin, vc_repository', 'required'),
			array('id_client, int_size, int_nbanwsers, int_tokens, int_teches', 'numerical', 'integerOnly'=>true),
			array('float_scoremin', 'numerical'),
			array('vc_name', 'length', 'max'=>128),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'id_client' => 'Client',
			'int_size' => 'Size',
			'int_nbanwsers' => 'Anwsers',
			'float_scoremin' => 'Score min',
			'int_tokens' => 'Tokens',
			'int_teches' => 'Technes',
			'nm_sens' => 'Sens',
			'vc_name' => 'Name',
			'vc_repository' => 'Repository',
			'vc_description' => 'Description',
		);
	}
	
	public function canAccess($user) {
//		$sql = "SELECT count(*) as rows FROM app_user_admin WHERE user_id = {$user->id} AND app_id = {$this->id}";
//		$command = $this->dbConnection->createCommand($sql);
//		$array = $command->queryColumn();
//		return $array[0] > 0;
		return $user->id == $this->id_client;
	}
}