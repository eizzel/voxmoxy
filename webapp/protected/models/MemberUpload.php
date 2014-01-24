<?php

/**
 * This is the model class for table "MemberUpload".
 *
 * The followings are the available columns in table 'MemberUpload':
 * @property integer $memberUploadId
 * @property string $dateCreated
 * @property string $dateLastModified
 * @property string $memberUploadTitle
 * @property string $memberUploadFilePath
 * @property integer $memberId
 *
 * The followings are the available model relations:
 * @property MemberUploadCategory[] $memberUploadCategories
 */
class MemberUpload extends Model
{
	public $uploaderName;
	public $categoryId;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MemberUpload the static model class
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
		return 'MemberUpload';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('memberId', 'required'),
			array('memberId', 'numerical', 'integerOnly'=>true),
			array('memberUploadTitle, memberUploadFilePath', 'length', 'max'=>256),
			array('dateCreated, dateLastModified', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('memberUploadId, dateCreated, dateLastModified, memberUploadTitle, memberUploadFilePath, memberId, uploaderName, categoryId', 'safe', 'on'=>'search'),
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
			'memberUploadCategory' => array(self::HAS_MANY, 'MemberUploadCategory', 'memberUploadId'),
			'member' => array(self::BELONGS_TO, 'Member', 'memberId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'memberUploadId' => 'Member Upload',
			'dateCreated' => 'Date Created',
			'dateLastModified' => 'Date Last Modified',
			'memberUploadTitle' => 'Member Upload Title',
			'memberUploadFilePath' => 'Member Upload File Path',
			'memberId' => 'Member',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('memberUploadId',$this->memberUploadId);
		$criteria->compare('dateCreated',$this->dateCreated,true);
		$criteria->compare('dateLastModified',$this->dateLastModified,true);
		$criteria->compare('memberUploadTitle',$this->memberUploadTitle,true);
		$criteria->compare('memberUploadFilePath',$this->memberUploadFilePath,true);
		$criteria->compare('memberId',$this->memberId);
		$criteria->compare('member.memberUserName', $this->uploaderName, true);
		$criteria->compare('memberUploadCategory.categoryId', $this->categoryId);
		
		$criteria->with = array('member', 'memberUploadCategory');
		$criteria->together = true;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder' => 'hex(t.memberUploadTitle)',
				'attributes' => array(
					'member.memberUserName' => array(
                        'asc' => 'hex(member.memberUserName)',
                        'desc' => 'hex(member.memberUserName) DESC',
                    ),
					'*'),
				
			),
		));
	}
}