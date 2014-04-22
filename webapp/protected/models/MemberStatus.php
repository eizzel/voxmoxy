<?php

/**
 * This is the model class for table "MemberStatus".
 *
 * The followings are the available columns in table 'MemberStatus':
 * @property integer $memberStatusId
 * @property string $dateCreated
 * @property string $dateLastModified
 * @property string $memberStatusName
 * @property string $memberStatusDescription
 */
class MemberStatus extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MemberStatus the static model class
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
		return 'MemberStatus';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('memberStatusName', 'length', 'max'=>45),
			array('dateCreated, dateLastModified, memberStatusDescription', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('memberStatusId, dateCreated, dateLastModified, memberStatusName, memberStatusDescription', 'safe', 'on'=>'search'),
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
			'memberStatusId' => 'Member Status',
			'dateCreated' => 'Date Created',
			'dateLastModified' => 'Date Last Modified',
			'memberStatusName' => 'Member Status Name',
			'memberStatusDescription' => 'Member Status Description',
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

		$criteria->compare('memberStatusId',$this->memberStatusId);
		$criteria->compare('dateCreated',$this->dateCreated,true);
		$criteria->compare('dateLastModified',$this->dateLastModified,true);
		$criteria->compare('memberStatusName',$this->memberStatusName,true);
		$criteria->compare('memberStatusDescription',$this->memberStatusDescription,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}