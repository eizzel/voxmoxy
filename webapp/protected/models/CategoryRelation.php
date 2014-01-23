<?php

/**
 * This is the model class for table "CategoryRelation".
 *
 * The followings are the available columns in table 'CategoryRelation':
 * @property integer $categoryRelationId
 * @property integer $parentCategoryId
 * @property integer $childCategoryId
 * @property integer $depth
 */
class CategoryRelation extends Model
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CategoryRelation the static model class
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
		return 'CategoryRelation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parentCategoryId, childCategoryId', 'required'),
			array('parentCategoryId, childCategoryId, depth', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('categoryRelationId, parentCategoryId, childCategoryId, depth', 'safe', 'on'=>'search'),
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
			'categoryRelationId' => 'Category Relation',
			'parentCategoryId' => 'Parent Category',
			'childCategoryId' => 'Child Category',
			'depth' => 'Depth',
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

		$criteria->compare('categoryRelationId',$this->categoryRelationId);
		$criteria->compare('parentCategoryId',$this->parentCategoryId);
		$criteria->compare('childCategoryId',$this->childCategoryId);
		$criteria->compare('depth',$this->depth);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}