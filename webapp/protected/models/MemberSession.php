<?php

/**
 * This is the model class for table "MemberSession".
 *
 * The followings are the available columns in table 'MemberSession':
 * @property integer $memberSessionId
 * @property string $dateCreated
 * @property string $dateLastModified
 * @property string $memberSessionIdentifier
 * @property integer $memberSessionPartialLogin
 * @property integer $memberId
 */
class MemberSession extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MemberSession the static model class
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
		return 'MemberSession';
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
			array('memberSessionPartialLogin, memberId', 'numerical', 'integerOnly'=>true),
			array('memberSessionIdentifier', 'length', 'max'=>100),
			array('dateCreated, dateLastModified', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('memberSessionId, dateCreated, dateLastModified, memberSessionIdentifier, memberSessionPartialLogin, memberId', 'safe', 'on'=>'search'),
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
			'memberSessionId' => 'Member Session',
			'dateCreated' => 'Date Created',
			'dateLastModified' => 'Date Last Modified',
			'memberSessionIdentifier' => 'Member Session Identifier',
			'memberSessionPartialLogin' => 'Member Session Partial Login',
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

		$criteria->compare('memberSessionId',$this->memberSessionId);
		$criteria->compare('dateCreated',$this->dateCreated,true);
		$criteria->compare('dateLastModified',$this->dateLastModified,true);
		$criteria->compare('memberSessionIdentifier',$this->memberSessionIdentifier,true);
		$criteria->compare('memberSessionPartialLogin',$this->memberSessionPartialLogin);
		$criteria->compare('memberId',$this->memberId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}