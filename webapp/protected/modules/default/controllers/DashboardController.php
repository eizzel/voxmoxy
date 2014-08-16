<?php
require_once 'google/appengine/api/cloud_storage/CloudStorageTools.php';
use google\appengine\api\cloud_storage\CloudStorageTools;

class DashboardController extends Controller
{
	public $layout='//layouts/column2LeftSidebar';
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow authenticated users
				'actions'=>array('index', 'myAccount', 'upload', 'viewUpload', 'download'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex()
	{
		$memberModel = Member::model()->findBypk(Yii::app()->user->id);
		$options = [ 'gs_bucket_name' => 'jabbervox'];
		$uploadUrl = CloudStorageTools::createUploadUrl('/dashboard', $options);
		
		$uploadForm = new FileUploadForm();
		
		if(isset($_POST['FileUploadForm']))
		{
			$uploadForm->attributes = $_POST['FileUploadForm'];
			$uploadForm->fileName = CUploadedFile::getInstance($uploadForm, 'fileName');
			
			if($uploadForm->validate())
			{
				//save memberUpload
				$tmpName = $uploadForm->fileName->tempName;
				$gsPath = 'gs://jabbervox/uploads/'.$memberModel->memberId.'/'.$uploadForm->fileName->name;
				$moveResults = move_uploaded_file($tmpName, $gsPath);
				
				if($moveResults)
				{
					$memberUpload = new MemberUpload();
					$memberUpload->memberId = $memberModel->memberId;
					$memberUpload->memberUploadFilePath = $gsPath;
					$memberUpload->memberUploadTitle = $uploadForm->title;
					$memberUpload->memberUploadDescription = $uploadForm->description;
					$memberUpload->memberUploadAuthor = $uploadForm->author;
					$memberUpload->save();
					
					Yii::app()->user->setFlash('success_upload', 'File upload successful!');
				}
			}
		}
		
		$uploadListSearch = new MemberUpload('search');
		$uploadListSearch->memberId = $memberModel->memberId;
		$uploadList = $uploadListSearch->search();
				
		$this->render('index', array(
			'uploadUrl' => $uploadUrl, 
			'uploadForm' => $uploadForm,
			'uploadList' => $uploadList,
			));
	}
	
	public function actionMyAccount()
	{
		$this->render('myAccount', array());
	}
	
	public function actionViewUpload($uploadId)
	{
		$memberUpload = MemberUpload::model()->findByPk($uploadId);
		$ratingForm = new RatingForm();
		
		if($memberUpload)
		{
			$ratingForm->memberUploadId = $uploadId;
			
			if($_POST['RatingForm'])
			{
				$ratingForm->attributes = $_POST['RatingForm'];
				if($ratingForm->validate())
				{
					// save rating
					$memberUploadRating = MemberUploadRating::model()->findByAttributes(array(
					'memberId' => Yii::app()->user->id,
					'memberUploadId' => $uploadId,
					));
					
					if(!$memberUploadRating)
					{
						$memberUploadRating = new MemberUploadRating();
						$memberUploadRating->memberId = Yii::app()->user->id;
						$memberUploadRating->memberUploadId = $uploadId;
					}
					$memberUploadRating->memberUploadRatingValue = $ratingForm->rating;
					$memberUploadRating->memberUploadRatingComments = $ratingForm->comments;
					
					$memberUploadRating->save();
				}
			}
			else
			{
				$memberUploadRating = MemberUploadRating::model()->findByAttributes(array(
				'memberId' => Yii::app()->user->id,
				'memberUploadId' => $uploadId,
				));

				if($memberUploadRating)
				{
					$ratingForm->rating = $memberUploadRating->memberUploadRatingValue;
					$ratingForm->comments = $memberUploadRating->memberUploadRatingComments;
				}
				
			}
			
			
			$downloadUrl = $this->createUrl('/default/dashboard/download/uploadId/'.$uploadId);
			$this->render('viewUpload', array(
				'memberUpload' => $memberUpload, 
				'downloadUrl' => $downloadUrl,
				'ratingForm' => $ratingForm));
		}
		else 
		{
			throw new CHttpException(404,'File not found.');
		}
		
	}
	
	public function actionDownload($uploadId)
	{
		$memberUpload = MemberUpload::model()->findByPk($uploadId);
		
		if($memberUpload)
		{
			$options = [ 'save_as' => basename($memberUpload->memberUploadFilePath), 'use_range' => false];
			CloudStorageTools::serve($memberUpload->memberUploadFilePath, $options);
		}
	}
}
