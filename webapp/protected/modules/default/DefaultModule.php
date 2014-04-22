<?php
class DefaultModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'default.models.*',
			'default.components.*',
		));
		
		if(!Yii::app()->user->id)
		{
			Yii::app()->setComponents( array(
			'user'=>array(
					'class'=>'WebUser',
					'loginUrl'=>'/login',
				),
			),false);
		}
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
