<?php
class db{
	private static $_instance = null;
	private $_pdo, 
			$_query, 
			$_error = false, 
			$_results,
			$_count,
			$_account = 0;

	private function __construct(){
		try{
			$this->_pdo = new PDO('mysql:host=' . config::get('mysql/host') . '; dbname=' . config::get('mysql/db'), config::get('mysql/username'), config::get('mysql/password'));
			//$this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public static function getInstance(){
		if(!isset(self::$_instance)){
			self::$_instance = new db();
		}
		return self::$_instance;
	}

	public function query($sql, $params = array()){
		$this->_error = false;

		if($this->_query = $this->_pdo->prepare($sql)){
			$x = 1;

			if(count($params) >= 1){
				foreach($params as $param){
					$this->_query->bindValue($x, $param);
					$x++;
				}
			}

			if($this->_query->execute()){
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_count = $this->_query->rowCount();
			} else {
				$this->_error = true;
			}
		}

		return $this;
	}

	public function action($action, $table, $where = array(), $extras = array()){
		if(count($where) === 3){
			$operators = array('=', '>', '<', '>=', '<=');

			$field = $where[0];
			$operator = $where[1];
			$value = $where[2];

			if(in_array($operator, $operators)){
				$sql = "{$action} FROM {$table} WHERE `{$field}` {$operator} '{$value}'";

				if(count($extras) === 3){
					$orderby = $extras[0];
					$desc = $extras[1];
					$limit = $extras[2];

					if($orderby){
						$sql = $sql . " ORDER BY `{$orderby}`";
					}

					if($desc === true){
						$sql = $sql . " DESC";
					}

					if($limit){
						$sql = $sql . " LIMIT {$limit}";
					}
				}
				
				if(!$this->query($sql, array($value))->error()){
					return $this;
				}
			}
		}

		return false;
	}

	public function get($table, $where, $extras = null){
		return $this->action('SELECT *', $table, $where, $extras);
	}

	public function getall($table){
		$sql = "SELECT * FROM {$table}";
		
		if(!$this->query($sql)->error()){
			return $this;
		}
	}

	public function delete($table, $where){
		return $this->action('DELETE', $table, $where);
	}

	public function insert($table, $fields = array()){
		if(count($fields)){

			$keys = array_keys($fields);
			$values = null;
			$x = 1;

			foreach($fields as $field){
				$values .= '?';

				if($x < count($fields)){
					$values .= ', ';
				}

				$x++;
			}

			$sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$values})";

			if(!$this->query($sql, $fields)->error()){
				return true;
			}
		}

		return false;
	}

	public function update($table, $fields, $where = array()){
		if(count($where) === 3){
			$operators = array('=', '>', '<', '>=', '<=');

			$field = $where[0];
			$operator = $where[1];
			$valueWhere = $where[2];

			$set = '';
			$x = 1;

			foreach($fields as $name => $value){
				$set .= "{$name} = ?";

				if($x < count($fields)){
					$set .= ', ';
				}

				$x++;
			}

			if(in_array($operator, $operators)){
				$sql = "UPDATE {$table} SET {$set} WHERE `{$field}` {$operator} '{$valueWhere}'";
			}	

			if(!$this->query($sql, $fields)->error()){
				return true;
			}

			return false;
		}

		return false;
	}

	public function results(){
		return $this->_results;
	}

	public function first(){
		return $this->results()[0];
	}

	public function second(){
		return $this->results()[1];
	}

	public function third(){
		return $this->results()[2];
	}

	public function error(){
		return $this->_error;
	}

	public function count(){
		return $this->_count;
	}
}