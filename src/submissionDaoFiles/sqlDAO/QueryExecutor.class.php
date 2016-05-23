<?php

class QueryExecutor{
	private $connection;

	function QueryExecutor(){
		$this->connection = new Connection();
		$this->begin();
	}

	public function execute($sqlQuery){
		$query = $sqlQuery->getQuery();
		$result = $this->connection->executeQuery($query);
		if(!$result){
			throw new Exception("SQL Error: -->".$query."<--" . pg_last_error());
		}
		$i=0;
		$tab = array();
		while ($row = pg_fetch_object($result)){
			$tab[$i++] = $row;
		}
		pg_free_result($result);
		return $tab;
	}
	
	
	public function executeUpdate($sqlQuery){

		$query = $sqlQuery->getQuery();
		$result = $this->connection->executeQuery($query);
		if(!$result){
			throw new Exception("SQL Error: -->".$query."<--" . pg_last_error());
		}
		$this->commit();
		return pg_affected_rows($result);		
	}

	public function executeInsert($sqlQuery){
		QueryExecutor::executeUpdate($sqlQuery);
		return pg_last_oid();
	}
	

	public function queryForString($sqlQuery){

		$result = $this->connection->executeQuery($sqlQuery->getQuery());
		if(!$result){
			throw new Exception("SQL Error: -->".$sqlQuery->getQuery()."<--" . pg_last_error());
		}
		$this->connection->getClose();		
		$row = pg_fetch_array($result);		
		return $row[0];
	}

	public function executeExport($name, $id, $path){
		$path = $path . DIRECTORY_SEPARATOR . $name;
		$this->connection->executeExport($path, $id);		
		$this->commit();
		return $path;
	}

	/**
	 * Conclusão da transação e salva as alterações
	 */
	protected function commit(){
		$this->connection->executeQuery('COMMIT');
		$this->connection->getClose();
	}

	/**
	 * A conclusão da transação e rollback
	 */
	protected function rollback(){
		$this->connection->executeQuery('ROLLBACK');
		$this->connection->getClose();
	}
	/**
	 * A conclusão da transação e rollback
	 */
	protected function begin(){
		$this->connection->executeQuery('BEGIN');
	}	

}
?>