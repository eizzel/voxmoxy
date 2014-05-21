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
				'actions'=>array('index', 'myAccount', 'upload'),
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
}
