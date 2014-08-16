<?php
class RatingForm extends CFormModel
{
	public $rating;
	public $comments;
	public $memberUploadId;
			
	public function rules()
	{
		return array(
			array('rating, memberUploadId, comments','required'),
			array('rating, memberUploadId, comments', 'safe'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rating' => 'Rating',
			'comments' => 'Comments',
			);
	}

}
