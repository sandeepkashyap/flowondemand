<?php

class IndexLog extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'index':
	 * @var integer $id
	 * @var integer $id_image
	 * @var string $vc_result
	 * @var integer $int_keypoint
	 * @var string $dt_created	 
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
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
//			'image'=>array(self::BELONGS_TO, 'Image', 'id_image', 'joinType'=>'INNER JOIN'),
    	);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'index_log';
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'id_image' => 'Image',
			'vc_result' => 'Result',
			'int_keypoint' => 'Key Point',
			'dt_created' => 'Date',			
		);
	}

	protected function beforeValidate()
	{
		if($this->isNewRecord)
			$this->dt_created = date('Y:m:d H:i:s');
		return true;
	}
	
	public function getIndicator() {
		if ($this->int_keypoint < 1) {
			return array("error", $this->vc_result);
		}
		if ($this->int_keypoint < 100) {
			return array("warning", "The keypoint is too small");
		}
		if ($this->int_keypoint < 500) {
			return array("warning", "The image seems to be too small or in low quality. Please check it or provide another");
		}
		return array('ok');
	}
	
}