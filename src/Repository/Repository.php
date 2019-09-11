<?php
namespace App\Repository;

use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

use App\Repository\RepositoryInterface;
use Cake\Log\Log;
use App\Entity\Entity;

class Repository implements RepositoryInterface{
	var $tableName;
	var $conn;

	function __construct()
	{
		$this->conn = ConnectionManager::get('default');
	    $this->tableName = substr((new \ReflectionClass($this))->getShortName(), 0, -10);
	}

	public function save($entity){
		$conn = $this->conn;
		try{
			$conn->begin();
			$query = $conn->newQuery();
			$data = [];
	    	$keys = [];
	    	foreach ($entity as $key => $value) {
	    		if($key!='id' && $key!='fillable') {
	    			$data[$key] = $value;
	    			$keys[] = $key;
	    		}
	    	}
			if($entity->id){
			    $query->update($this->tableName)->set($data)->where(['id'=>$entity->id]);
		    } else {
		    	$query->into($this->tableName)->insert($keys)->values($data);
		    }
		    $query->execute();
         	$conn->commit();
	    }catch(Exception $e){
	    	$conn->rollback();
         	echo 'Error:'.$e->getMessage();
	        return;
	    }
		
	}

	public function delete($id){
		$conn = $this->conn;
		try{
			$conn->begin();
			$query = $conn->newQuery();
			
			$query->delete($this->tableName)->where(['id'=>$id]);
		    $query->execute();
         	$conn->commit();
	    }catch(Exception $e){
	    	$conn->rollback();
         	echo 'Error:'.$e->getMessage();
	        return;
	    }
	}

	public function deleteList($conditions){
		$conn = $this->conn;
		try{
			$conn->begin();
			$query = $conn->newQuery();
			
			$query->delete($this->tableName)->where($conditions);
		    $query->execute();
         	$conn->commit();
	    }catch(Exception $e){
	    	$conn->rollback();
         	echo 'Error:'.$e->getMessage();
	        return;
	    }
		
	}

	public function get($id){
		$conn = $this->conn;
		$query = $conn->newQuery();
		$query->select("*")->from($this->tableName)
		    ->where(['id'=>$id]);
        $stmt = $query->execute();
		$row = $stmt->fetch('assoc');
		return $row;
	}

	public function getList($conditions){
		$conn = $this->conn;
		$query = $conn->newQuery();
		$query->select("*")->from($this->tableName)
		    ->where($conditions);
        $stmt = $query->execute();
		$rows = $stmt->fetchAll('assoc');
		return $rows;
	}

	public function find($conditions){
		$conn = $this->conn;
		$query = $conn->newQuery();
		$query->select("*")->from($this->tableName)
		    ->where($conditions);
		return $query;
	}
}