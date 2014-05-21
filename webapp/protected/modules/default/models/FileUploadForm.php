<?php
class FileUploadForm extends CFormModel
{
	public $title;
	public $author;
	public $description;
	public $fileName;
		
	public function rules()
	{
		return array(
			array('fileName, title','required'),
			array('fileName', 'file', 'safe' => true, 'types' => '3gp,act,AIFF,aac,ALAC,amr,atrac,Au,awb,dct,dss,dvf,flac,gsm,iklax,IVS,m4a,m4p,mmf,mp3,mpc,msv,ogg,Opus,ra,rm,raw,TTA,vox,wav,wma'),
			array('fileName, title, author, description', 'safe'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'fileName' => 'Audio File',
			'title' => 'Title',
			'description' => 'Description',
			'author' => 'Author',
			);
	}

}
