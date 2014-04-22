<?php
class DbStatePersister extends CStatePersister {

    /**
     * @var boolean if the database table should be automatically created if it does not exist.
     * Defaults to TRUE.
     */
    public $autoCreatePersisterTable = TRUE;

    /**
     * @var string the table name, defaults to YiiPersister
     */
    public $persisterTableName = 'YiiPersister';

    /**
     * @var string the ID of the connection component, defaults to 'db'
     */
    public $connectionID = 'db';

    /**
     * @var CDbConnection the DB connection instance
     */
    private $_db;


    protected function createPersisterTable($db,$tableName)
    {
        $sql="
CREATE TABLE $tableName
(
id int PRIMARY KEY,
data TEXT
)";
        $db->createCommand($sql)->execute();
    }

    protected function getDbConnection()
    {
        $id = $this->connectionID;

        if(($this->_db == null) &&
            (false === (Yii::app()->getComponent($id) instanceof CDbConnection)))
                throw new CException(Yii::t('yii','CDbHttpSession.connectionID "{id}" is invalid. Please make sure it refers to the ID of a CDbConnection application component.', array('{id}'=>$id)));

        $this->_db = Yii::app()->getComponent($id);
        return $this->_db;
    }


    /**
     * Initializes the component.
     */
    public function init()
    {
        $db=$this->getDbConnection();
        $db->setActive(true);

        if($this->autoCreatePersisterTable && 
            null === $db->schema->getTable($this->persisterTableName)
        ) {
            $this->createPersisterTable($db,$this->persisterTableName);
        }
        return true;
    }

    /**
     * Loads state data from persistent storage.
     * @return mixed state data. Null if no state data available.
     */
    public function load()
    {
        $retval = null;

        if(($content=$this->getContents())!==false)
               $retval = unserialize($content);

        return $retval;
    }

    /**
     * Read the data from the table
     */
    private function getContents()
    {
        $retval = null;

        $sql="
SELECT data FROM {$this->persisterTableName}
WHERE id=1
";
        $data = $this->getDbConnection()->createCommand($sql)->queryScalar();

        if ($data === false)
            $retval = $data;

        return $retval;

    }

    /**
     * Saves application state in persistent storage.
     * @param mixed $state state data (must be serializable).
     */
    public function save($state)
    {
        $retval = true;
        $data = serialize($state);
        try {
                $db=$this->getDbConnection();
                $sql="SELECT id FROM {$this->persisterTableName} WHERE id=1";
                if($db->createCommand($sql)->queryScalar()===false)
                        $sql="INSERT INTO {$this->persisterTableName} (id, data) VALUES (1, :data)";
                else
                        $sql="UPDATE {$this->persisterTableName} SET data=:data WHERE id=1";
                $db->createCommand($sql)->bindValue(':data',$data)->execute();
        }
        catch(Exception $e) {
            $retval = false;
            if(YII_DEBUG)
                echo $e->getMessage();
        }
        return $retval;
    }
}
