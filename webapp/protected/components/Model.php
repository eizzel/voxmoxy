<?php
class Model extends CActiveRecord
{
	public $updateLastModified = true; //updates dateLastModified column before save
	/*
	 * This function handles the default values for the
	 * dateCreated and dateLastModified columns
	 */
	public function beforeSave()
	{
		if($this->isNewRecord)
		{
            if($this->hasAttribute('dateCreated'))
            {
                $this->dateCreated = new CDbExpression('NOW()');
            }
		}
        
        if($this->hasAttribute('dateLastModified') && $this->updateLastModified)
        {
            $this->dateLastModified = new CDbExpression('NOW()');
        }
		
		return parent::beforeSave();
	}
	
	/*
	 * This function adds the behavior to automatically save
	 * related models
	 */
	/*public function behaviors()
	{
        $addBehavior = array('CSaveRelationsBehavior' => array('class' => 'application.components.CSaveRelationsBehavior'));
		$behaviors = array_merge(parent::behaviors(), $addBehavior);
		
		return $behaviors;
	}*/
	
	public function beforeDelete()
	{
		$deletedColumn = lcfirst($this->tableName()).'Deleted';
		if($this->hasAttribute($deletedColumn))
		{
			$this->$deletedColumn = 1;
			//var_dump($this->save());
			//exit();
			$this->save();
			return false;
		}
		
		return parent::beforeDelete();
	}
}

