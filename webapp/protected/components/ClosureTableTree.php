<?php
class ClosureTableTree
{
	private $_sourceTable;
	private $_relationTable;
	private $_childField;
	private $_parentField;
	private $_textField;
	
	private $_nodeList = array();
	private $_listByParents = array();
	
	public $internalCriteria;
		
	public function __construct($args)
	{
		$this->_sourceTable = $args['sourceTable'];
		$this->_relationTable = $args['relationTable'];
		$this->_childField = $args['childField'];
		$this->_parentField = $args['parentField'];
		$this->_textField = $args['textField'];		
	}
	
	public function getChildren($id = 1)
	{
		// root id == 1; //BAD!!!
		$children = $this->getChildrenFromDb($id);
		
		// build parent list and data array (used in building the tree)
		$parentList = array();
		$dataArray = array();
		
		foreach($children as $row)
		{
			$parentList[$row[$this->_parentField]][] = $row[$this->_childField];
			$data['title'] = $row[$this->_textField]; 
			$data['text'] = $row[$this->_textField];
			
			$data['expanded'] = false;
			$dataArray[$row[$this->_sourceTable->tableSchema->primaryKey]] = $data;
		}
		
		//build the tree
		$tree = array();
		$mainStack = $parentList[$id];
		$targetStack[] = &$tree;
		
		while(!empty($mainStack))
		{
			$target = &$targetStack[count($targetStack)-1];
			
			if(count($targetStack) > 1)
			array_pop($targetStack);
			
			$targetId = array_shift($mainStack);
			$target[$targetId] = $dataArray[$targetId];
						
			if($parentList[$targetId])
			{
				$target[$targetId]['children'] = array();
				
				foreach(array_reverse($parentList[$targetId],true) as $child)
				{
					$targetStack[] = &$target[$targetId]['children'];
					array_unshift($mainStack, $child);
				}
				
				unset($parentList[$targetId]);
			}
		}
		
		return $tree;
	}
	
	public function getChildrenAsFlatArray($id = 1)
	{
		// root id == 1; //BAD!!!
		$children = $this->getChildrenFromDb($id);
		
		// build parent list and data array (used in building the tree)
		$parentList = array();
		$dataArray = array();
		
		foreach($children as $row)
		{
			$parentList[$row[$this->_parentField]][] = $row[$this->_childField];
			$data['title'] = $row[$this->_textField]; 
			$data['text'] = $row[$this->_textField];
			$data['depth'] = $row['depth'];
			
			$dataArray[$row[$this->_sourceTable->tableSchema->primaryKey]] = $data;
		}
		
		//build the tree
		$tree = array();
		$mainStack = $parentList[$id];
		//$targetStack[] = &$tree;
		
		while(!empty($mainStack))
		{
			$targetId = array_shift($mainStack);
			$padLength = strlen(trim($dataArray[$targetId]['title']))+(($dataArray[$targetId]['depth']-1)*12);
			
			$tree[(int)$targetId] = str_pad($dataArray[$targetId]['title'], $padLength, "&nbsp;&nbsp;", STR_PAD_LEFT);;
						
			if($parentList[$targetId])
			{
				foreach(array_reverse($parentList[$targetId],true) as $child)
				{
					array_unshift($mainStack, $child);
				}
				
				unset($parentList[$targetId]);
			}
		}
		
		return $tree;
	}
			
	public function addParent($parentId, $childId)
	{
		$db = Yii::app()->db;
		
		$sql = "INSERT 
			INTO {$this->_relationTable->tableName()}({$this->_parentField}, {$this->_childField}, depth)
			SELECT t1.{$this->_parentField}, t2.{$this->_childField}, t1.depth+t2.depth+1
			FROM 
				{$this->_relationTable->tableName()} t1, 
				{$this->_relationTable->tableName()} t2
			WHERE t1.{$this->_childField}=:parentId and t2.{$this->_parentField}=:childId;";
		
		$command = $db->createCommand($sql);
		$command->bindParam(':parentId', $parentId);
		$command->bindParam(':childId', $childId);
		
		return $command->execute();
	}
	
	public function removeParent($parentId, $childId)
	{
		$db = Yii::app()->db;
		
		$sql = "DELETE t2 FROM
			{$this->_relationTable->tableName()} t1,
			{$this->_relationTable->tableName()} t2,
			{$this->_relationTable->tableName()} t3
			WHERE
			t1.{$this->_parentField} = t2.{$this->_parentField}
			AND t2.{$this->_childField} = t3.{$this->_childField}
			AND t1.{$this->_childField} = :parentId
			AND t3.{$this->_parentField} = :childId
			";
			
		$command = $db->createCommand($sql);
		$command->bindParam(':parentId', $parentId);
		$command->bindParam(':childId', $childId);
		
		return $command->execute();
	}
	
	private function getChildrenFromDb($id)
	{
		$db = Yii::app()->db;
				
		$criteria = new CDbCriteria();
		$criteria->select = "t2.{$this->_parentField}, t2.{$this->_childField}, s.*, t.depth+1 AS depth";
		$criteria->join = " INNER JOIN {$this->_relationTable->tableName()} as t2 ON t.{$this->_childField} = t2.{$this->_parentField} ";
		$criteria->join .= " LEFT JOIN {$this->_sourceTable->tableName()} AS s ON t2.{$this->_childField} = s.{$this->_sourceTable->tableSchema->primaryKey} ";
		
		$criteria->addCondition('t2.depth = 1');
		$criteria->addCondition("t.{$this->_parentField} = :id");
		
		if($this->_sourceTable->hasAttribute(lcfirst($this->_sourceTable->tableName()).'Deleted'))
		{
			$deletedColumnName = lcfirst($this->_sourceTable->tableName()).'Deleted';
			$criteria->addCondition("$deletedColumnName IS NULL OR $deletedColumnName = 0");
		}
		
		$criteria->order = " t.depth, hex(s.{$this->_textField})";
			
		$criteria->params = array(':id'=>$id);
		
		// Combine if internal criteria is present
		if(isset($this->internalCriteria))
		{
			$criteria->mergeWith($this->internalCriteria);
		}
		
		$tableSchema = $this->_relationTable->getTableSchema();
		$command = $this->_relationTable->getCommandBuilder()->createFindCommand($tableSchema, $criteria);
	
		return $command->queryAll();
	}
	
	public function getImmediateParents($id)
	{
		$db = Yii::app()->db;
		
		$sql = "SELECT {$this->_parentField} 
			FROM {$this->_relationTable->tableName()} 
			WHERE {$this->_childField} = :id AND depth = 1";
		
		$command = $db->createCommand($sql);
		$command->bindParam(':id', $id);
		
		$result = $command->queryAll();
		$parents = array();
		
		if(!empty($result))
		{
			foreach($result as $res)
			{
				$parents[] = $res[$this->_parentField];
			}
		}
		return $parents;
	}
	
	public function deleteNode($id)
	{
		$db = Yii::app()->db;
		
		$sql = "DELETE link
			FROM {$this->_relationTable->tableName()} p, {$this->_relationTable->tableName()} link, {$this->_relationTable->tableName()} c, {$this->_relationTable->tableName()} to_delete
			WHERE p.{$this->_parentField} = link.{$this->_parentField} AND c.{$this->_childField} = link.{$this->_childField}
				AND p.{$this->_childField} = to_delete.{$this->_parentField} and c.{$this->_parentField} = to_delete.{$this->_childField}
				AND (to_delete.{$this->_parentField} = :id OR to_delete.{$this->_childField} = :id)
				AND to_delete.depth < 2;";
		
		$command = $db->createCommand($sql);
		$command->bindParam(':id', $id);
		
		return $command->execute();
	}
	
	public function getRootNodes()
	{
		$db = Yii::app()->db;
		
		$sql = "SELECT {$this->_parentField} 
			FROM {$this->_relationTable->tableName()}
			GROUP BY {$this->_childField}
			HAVING count(*) = 1;";
			
		$command = $db->createCommand($sql);
		$results = $command->queryAll();
		$rootNodes = array();
		
		if(!empty($results))
		{
			foreach($results as $res)
			{
				$rootNodes[] = $res[$this->_parentField];
			}
		}
		
		return $rootNodes;
	}
	
	public function addNode($id)
	{
		$relationTable = $this->_relationTable;
		
		if(!$relationTable->exists("{$this->_parentField} = :id AND {$this->_childField} = :id", array(':id' => $id)))
		{
			$parentField = $this->_parentField;
			$childField = $this->_childField;
			
			$tableName = $this->_relationTable->tableName();
			$newNode = new $tableName;
			$newNode->$parentField = $id;
			$newNode->$childField = $id;
			$newNode->depth = 0;
			return $newNode->save();			
		}
		return true;
	}
	
}
