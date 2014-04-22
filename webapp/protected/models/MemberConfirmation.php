<?php

/**
 * This is the model class for table "MemberConfirmation".
 *
 * The followings are the available columns in table 'MemberConfirmation':
 * @property integer $memberConfirmationId
 * @property string $dateCreated
 * @property string $dateLastModified
 * @property string $memberConfirmationCode
 * @property integer $memberConfirmationConfirmed
 * @property integer $memberId
 */
class MemberConfirmation extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MemberConfirmation the static model class
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
		return 'MemberConfirmation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('memberConfirmationCode, memberId', 'required'),
			array('memberConfirmationConfirmed, memberId', 'numerical', 'integerOnly'=>true),
			array('memberConfirmationCode', 'length', 'max'=>255),
			array('dateCreated, dateLastModified', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('memberConfirmationId, dateCreated, dateLastModified, memberConfirmationCode, memberConfirmationConfirmed, memberId', 'safe', 'on'=>'search'),
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
			'memberConfirmationId' => 'Member Confirmation',
			'dateCreated' => 'Date Created',
			'dateLastModified' => 'Date Last Modified',
			'memberConfirmationCode' => 'Member Confirmation Code',
			'memberConfirmationConfirmed' => 'Member Confirmation Confirmed',
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

		$criteria->compare('memberConfirmationId',$this->memberConfirmationId);
		$criteria->compare('dateCreated',$this->dateCreated,true);
		$criteria->compare('dateLastModified',$this->dateLastModified,true);
		$criteria->compare('memberConfirmationCode',$this->memberConfirmationCode,true);
		$criteria->compare('memberConfirmationConfirmed',$this->memberConfirmationConfirmed);
		$criteria->compare('memberId',$this->memberId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}