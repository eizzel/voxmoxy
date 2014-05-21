<?php

/**
 * This is the model class for table "MemberUploadRating".
 *
 * The followings are the available columns in table 'MemberUploadRating':
 * @property integer $memberUploadRatingId
 * @property string $dateCreated
 * @property string $dateLastModified
 * @property integer $memberUploadRatingValue
 * @property string $memberUploadRatingComments
 * @property integer $memberUploadId
 * @property integer $memberId
 */
class MemberUploadRating extends Model
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MemberUploadRating the static model class
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
		return 'MemberUploadRating';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('memberUploadId, memberId', 'required'),
			array('memberUploadRatingValue, memberUploadId, memberId', 'numerical', 'integerOnly'=>true),
			array('dateCreated, dateLastModified, memberUploadRatingComments', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('memberUploadRatingId, dateCreated, dateLastModified, memberUploadRatingValue, memberUploadRatingComments, memberUploadId, memberId', 'safe', 'on'=>'search'),
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
			'memberUploadRatingId' => 'Member Upload Rating',
			'dateCreated' => 'Date Created',
			'dateLastModified' => 'Date Last Modified',
			'memberUploadRatingValue' => 'Member Upload Rating Value',
			'memberUploadRatingComments' => 'Member Upload Rating Comments',
			'memberUploadId' => 'Member Upload',
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

		$criteria->compare('memberUploadRatingId',$this->memberUploadRatingId);
		$criteria->compare('dateCreated',$this->dateCreated,true);
		$criteria->compare('dateLastModified',$this->dateLastModified,true);
		$criteria->compare('memberUploadRatingValue',$this->memberUploadRatingValue);
		$criteria->compare('memberUploadRatingComments',$this->memberUploadRatingComments,true);
		$criteria->compare('memberUploadId',$this->memberUploadId);
		$criteria->compare('memberId',$this->memberId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}