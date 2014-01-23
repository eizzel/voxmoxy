<?php

/**
 * This is the model class for table "MemberUploadCategory".
 *
 * The followings are the available columns in table 'MemberUploadCategory':
 * @property integer $memberUploadCategoryId
 * @property string $dateCreated
 * @property string $dateLastModified
 * @property integer $memberUploadId
 * @property integer $categoryId
 *
 * The followings are the available model relations:
 * @property MemberUpload $memberUpload
 * @property Category $category
 */
class MemberUploadCategory extends Model
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MemberUploadCategory the static model class
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
		return 'MemberUploadCategory';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('memberUploadId, categoryId', 'required'),
			array('memberUploadId, categoryId', 'numerical', 'integerOnly'=>true),
			array('dateCreated, dateLastModified', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('memberUploadCategoryId, dateCreated, dateLastModified, memberUploadId, categoryId', 'safe', 'on'=>'search'),
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
			'memberUpload' => array(self::BELONGS_TO, 'MemberUpload', 'memberUploadId'),
			'category' => array(self::BELONGS_TO, 'Category', 'categoryId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'memberUploadCategoryId' => 'Member Upload Category',
			'dateCreated' => 'Date Created',
			'dateLastModified' => 'Date Last Modified',
			'memberUploadId' => 'Member Upload',
			'categoryId' => 'Category',
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

		$criteria->compare('memberUploadCategoryId',$this->memberUploadCategoryId);
		$criteria->compare('dateCreated',$this->dateCreated,true);
		$criteria->compare('dateLastModified',$this->dateLastModified,true);
		$criteria->compare('memberUploadId',$this->memberUploadId);
		$criteria->compare('categoryId',$this->categoryId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}