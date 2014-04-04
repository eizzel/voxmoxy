<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
	
	public function actionSearch()
	{
		$data = new ClosureTableTree(array(
				'sourceTable' => Category::model(),
				'relationTable' => CategoryRelation::model(),
				'parentField' => 'parentCategoryId',
				'childField' => 'childCategoryId',
				'textField' => 'categoryName',
				));
		
		$treeData = $data->getChildren();
		
		$this->beginClip('categories');
		$this->widget(
			'CTreeView',
			array('data' => $treeData,
					//'collapsed' => false,
					/*'htmlOptions' => array('class'=>'expanded')*/)
		);
		$this->endClip();
		
		$model=new MemberUpload('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MemberUpload']))
			$model->attributes=$_GET['MemberUpload'];

		$dataSource = $model->search();
		
		$this->layout = '//layouts/column2LeftSidebar';
		$this->render('search', array('dataSource' => $dataSource));
	}
	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
	
	public function actionSignup()
	{
		$signupForm = new SignUpForm();
		
		if($_POST['SignUpForm'])
		{
			$signupForm->attributes = $_POST['SignUpForm'];
			
			if($signupForm->validate())
			{
				//save member data
				$bCrypt = new bCrypt();
				
				$member = new Member();
				$member->memberUserName = $signupForm->userName;
				$member->memberFirstName = $signupForm->firstName;
				$member->memberLastName = $signupForm->lastName;
				$member->memberPassword = $bCrypt->hash($signupForm->password);
				
				$member->save();
			}
			
		}
		$this->render('signup', array('model' => $signupForm));
	}
}