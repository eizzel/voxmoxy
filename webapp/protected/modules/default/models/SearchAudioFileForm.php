<?php
class SearchAudioFileForm extends CFormModel
{
	public $attribute;
	public $searchText;
	public $attributeList = array(
		'member.memberUserName'=>'author',
		'memberUpload.memberUploadTitle'=>'title',
	);
	
	public function rules()
	{
		return array();
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array();
	}

}
