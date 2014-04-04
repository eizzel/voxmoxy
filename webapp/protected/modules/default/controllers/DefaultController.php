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
		d($_GET);
		if(isset($_GET['SearchAudioFileForm']))
		{
			$model->setAttribute($_GET['SearchAudioFileForm']['attribute'], $_GET['SearchAudioFileForm']['searchText']);
		}
		d($model);
		
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