<?php
class Db_connection{
	const DB_NAME = 'texnadzor';
	const DB_USER = 'root';
	const DB_PASSWORD = '';
	const DB_HOST = 'localhost';

	/*const DB_NAME = '';
	const DB_USER = '';
	const DB_PASSWORD = '';
	const DB_HOST = '';*/

	protected $conn;

	protected function db_connect(){
		try {
			$this->conn = new PDO("mysql:host=".self::DB_HOST.";dbname=".self::DB_NAME, self::DB_USER, self::DB_PASSWORD);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return true ; 
		}
		catch(PDOException $e){
			var_dump($e);
			return false;
		 }
	}

	protected function get_id($table){
		if($this->conn == null){
			$this->db_connect();
		}
		if($this->conn){
			$sql = "SELECT id FROM ".$table;
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->setFetchMode(PDO::FETCH_BOTH);
			if($result){
				$result = $stmt->fetchAll();
				$id = rand(0,999999999);
				if(is_array($result)){
					for($i = 0; $i<count($result); $i++){
						if($result[$i] == $id){
							$id = rand(0,999999999);
							$i = 0;
						}
					}
				}
				return $id;
			}
		}
	}

	public function set_data($table,$titles,$values){

			if($this->conn == null){
				$this->db_connect();
			}
			if($this->conn){
				$sql = "INSERT INTO ".$table." (".$titles.") VALUES ('".$values."')";
				$result = $this->conn->exec($sql);
				return $result;
				$this->conn = null;
			}
	}

	public function get_data($table,$what="*",$condition=''){

		if($this->conn == null){
			$this->db_connect();
		}
		if($this->conn){
			$sql = "SELECT ".$what." FROM ".$table." WHERE ".$condition;
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
			if($result){
				$result = $stmt->fetchAll();
				if(is_array($result)){
					return $result;
				}else{
					return false;
				}
				
			}
		}
		$this->conn = null;
	}
	
	public function update_data($table,$set,$condition){
			
			if($this->conn == null){
				$this->db_connect();
			}
			if($this->conn){
				$date = date('d-m-Y H:i:s');
				$sql = "UPDATE ".$table." SET ".$set." WHERE ".$condition." ";
				$stmt = $this->conn->prepare($sql);
    			$result = $stmt->execute();
				return $result;
				$this->conn = null;
			}
	}
	
}
?>