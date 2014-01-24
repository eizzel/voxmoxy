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
		
		$this->layout = '//layouts/column2LeftSidebar';
		$this->render('search');
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
}