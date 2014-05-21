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
		
	   

		# apply span to all text in the tree
		# the span tag would allow the treeview jquery plugin
		# to apply css and event handler to tree labels (builtin feature)
		reset($treeData);
		foreach($treeData as $key => $tData)
		{
			$treeData[$key] = $this->applyNodeTextWrapper($key, $tData);
		}
				
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
		
		if(isset($_GET['SearchAudioFileForm']))
		{
			$model->setAttribute($_GET['SearchAudioFileForm']['attribute'], $_GET['SearchAudioFileForm']['searchText']);
		}
		
		/**
		* Add treeview behaviour that will filter out org table when a tree label is clicked
		*/
		Yii::app()->clientScript->registerScript('treeviewInteractOverride', "
		   $('#sidebar').on('click', 'ul.treeview li a', function(e)
		   {
			   var categoryId = $(this).attr('categoryId');
			   var searchParams = new Object();

			   searchParams['SearchAudioFileForm[attribute]'] = 'categoryId';
			   searchParams['SearchAudioFileForm[searchText]'] = categoryId;
			   
			   $.fn.yiiGridView.update('memberUpload-grid', {
				   data: searchParams
			   });
			   return false;
		   });
		");
			

		$dataSource = $model->search();
		
		$this->layout = '//layouts/column2LeftSidebar';
		$this->render('search', array('dataSource' => $dataSource));
	}
	
	private function applyNodeTextWrapper($nodeId, $node)
	{
		$node['orgUnitId'] = $nodeId;
		$node['text'] = '<a href="#" categoryId="'.$nodeId.'">'.$node['text'].'</a>';

		if (isset($node['children'])) {
			foreach ($node['children'] as $idx => &$child)
			{
				$child = $this->applyNodeTextWrapper($idx, $child);
			}

			unset($child);
		}

		return $node;
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
			
			if (isset($_POST['ajax']) && $_POST['ajax'] === 'signUpForm')
			{	
				echo CActiveForm::validate($signupForm);
				Yii::app()->end();
			}
			
			if($signupForm->validate())
			{
				//save member data
				$bCrypt = new bCrypt();
				$unconfirmedStatus = MemberStatus::model()->findByAttributes(array('memberStatusName' => 'unconfirmed'))->memberStatusId;
				
				$member = new Member();
				$member->memberUserName = $signupForm->userName;
				$member->memberEmail = $signupForm->email;
				$member->memberFirstName = $signupForm->firstName;
				$member->memberLastName = $signupForm->lastName;
				$member->memberPassword = $bCrypt->hash($signupForm->password);
				$member->memberStatusId = $unconfirmedStatus;
				$member->save();
				
				//send confirmation email
				Yii::app()->user->sendConfirmationEmail($member->memberId);
				
				//show success message
				Yii::app()->clientScript->registerScript('signupSuccess','
					$(document).ready(function(){
					$("#signUpForm").notify("Thanks for signing up! We\'ve sent an email to: '.$member->memberEmail.' to verify your account. \n\nPlease click on the confirmation link to start sharing.",
						{autoHide: false, elementPosition: "right top", className: "success", arrowSize: 10});			
					});');
			}
			
		}
		$this->render('signup', array('model' => $signupForm));
	}
	
	public function actionConfirm($code, $mId)
	{
		// verify code
		$bCrypt = new bCrypt();
		$memberConfirmation = MemberConfirmation::model()->findByAttributes(array('memberId'=>$mId));
						
		if($bCrypt->verify($code, $memberConfirmation->memberConfirmationCode))
		{
			$member = Member::model()->findByPk($mId);
			$confirmedStatus = MemberStatus::model()->findByAttributes(array('memberStatusName' => 'confirmed'))->memberStatusId;
			
			if($member->memberId)
			{
				// if member already confirmed and is active, redirect to dashboard
				if($member->memberStatusId == $confirmedStatus)
				{
					Yii::app()->user->setFlash('success_confirm', "Your email address: {$member->memberEmail} is now confirmed!");					
					$this->redirect('/dashboard');					
				}
				
				$member->memberStatusId = $confirmedStatus;
				$member->save();
				
				Yii::app()->user->logOut();
				Yii::app()->session->open();
				$identity=new UserIdentity($member->memberEmail,$member->memberPassword);
				$identity->authenticate(true); // partial login
					
				if($identity->errorCode === UserIdentity::ERROR_NONE)
				{
					$duration = 3600; // 1 hour
					Yii::app()->user->login($identity,$duration); //partial login
				}
				Yii::app()->user->setFlash('success_confirm', "Your email address: {$member->memberEmail} is now confirmed!");					
										
				$this->redirect('/dashboard');
			}			
		}
		
		$this->redirect(Yii::app()->user->returnUrl);
	}
	
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
			{
				//save machine data
				//save memberMachineData
				if($_POST['MachineData'])
				{
					$memberMachineData = new MemberMachineData();
					$memberMachineData->attributes = $_POST['MachineData'];
					$memberMachineData->memberId = Yii::app()->user->id;
					$memberMachineData->ipAddress = $_SERVER['REMOTE_ADDR'];
					$memberMachineData->userAgentString = $_SERVER['HTTP_USER_AGENT'];
					$memberMachineData->save();
					
				}
				$this->redirect('/dashboard');
			}
				
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}
	
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
}