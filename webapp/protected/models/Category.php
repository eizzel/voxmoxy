<?php

/**
 * This is the model class for table "Category".
 *
 * The followings are the available columns in table 'Category':
 * @property integer $categoryId
 * @property string $dateCreated
 * @property string $dateLastModified
 * @property string $categoryName
 *
 * The followings are the available model relations:
 * @property MemberUploadCategory[] $memberUploadCategories
 */
class Category extends Model
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Category the static model class
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
		return 'Category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('categoryName', 'length', 'max'=>100),
			array('dateCreated, dateLastModified', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('categoryId, dateCreated, dateLastModified, categoryName', 'safe', 'on'=>'search'),
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
			'memberUploadCategories' => array(self::HAS_MANY, 'MemberUploadCategory', 'categoryId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'categoryId' => 'Category',
			'dateCreated' => 'Date Created',
			'dateLastModified' => 'Date Last Modified',
			'categoryName' => 'Category Name',
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

		$criteria->compare('categoryId',$this->categoryId);
		$criteria->compare('dateCreated',$this->dateCreated,true);
		$criteria->compare('dateLastModified',$this->dateLastModified,true);
		$criteria->compare('categoryName',$this->categoryName,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}