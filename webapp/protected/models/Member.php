<?php

/**
 * This is the model class for table "Member".
 *
 * The followings are the available columns in table 'Member':
 * @property integer $memberId
 * @property string $dateCreated
 * @property string $dateLastModified
 * @property string $memberUserName
 * @property string $memberEmail
 * @property string $memberFirstName
 * @property string $memberLastName
 * @property string $memberPassword
 */
class Member extends Model
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Member the static model class
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
		return 'Member';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('memberUserName, memberEmail, memberFirstName, memberLastName, memberPassword', 'length', 'max'=>100),
			array('dateCreated, dateLastModified', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('memberId, dateCreated, dateLastModified, memberUserName, memberEmail, memberFirstName, memberLastName, memberPassword', 'safe', 'on'=>'search'),
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
			'memberId' => 'Member',
			'dateCreated' => 'Date Created',
			'dateLastModified' => 'Date Last Modified',
			'memberUserName' => 'Member User Name',
			'memberEmail' => 'Member Email',
			'memberFirstName' => 'Member First Name',
			'memberLastName' => 'Member Last Name',
			'memberPassword' => 'Member Password',
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

		$criteria->compare('memberId',$this->memberId);
		$criteria->compare('dateCreated',$this->dateCreated,true);
		$criteria->compare('dateLastModified',$this->dateLastModified,true);
		$criteria->compare('memberUserName',$this->memberUserName,true);
		$criteria->compare('memberEmail',$this->memberEmail,true);
		$criteria->compare('memberFirstName',$this->memberFirstName,true);
		$criteria->compare('memberLastName',$this->memberLastName,true);
		$criteria->compare('memberPassword',$this->memberPassword,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}