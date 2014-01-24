<?php
class SearchAudioFileForm extends CFormModel
{
	public $attribute;
	public $searchText;
	public $attributeList = array(
		'memberUploadTitle'=>'Title',
		'uploaderName'=>'Uploader',
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
		return array('attribute' => 'Search By');
	}

}
