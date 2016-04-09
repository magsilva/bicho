<?php

class SubmissionPostgresDAO implements SubmissionDAO{


	/**
 	 * Delete record from table
 	 */
	public function delete(){

	}
	
	/**
 	 * Insert record to table
 	 *
 	 */
	public function insert(){

	}
	
	/**
 	 * Update record in table
 	 *
 	 */
	public function update(){

	}

	/**
 	 * Read record in table
 	 *
 	 */
	public function read($contestnumber, $runnumber){
		$sql = 'SELECT r.rundata as rundata, r.runfilename as runfilename '.
			   'FROM runtable as r '.
			   'WHERE r.contestnumber= ? AND r.runnumber = ?';
			   
		$sqlQuery = new SqlQuery($sql);					   
		$sqlQuery->setNumber($contestnumber);
		$sqlQuery->setNumber($runnumber);

		$answerSql = $this->execute($sqlQuery);
		$path = $this->executeExport($answerSql["runfilename"], $answerSql["rundata"]);	
		$answerSql["pathToExport"] = $path;
		// $answerSql = ('contestnumber' => $contestnumber);
		// $answerSql = ('runnumber' => $runnumber);
		return $answerSql;		
	}

	/**
 	 * Read record in table
 	 *
 	 */
	public function readAll(){

	}

	/**
	 * Execute sql query
	 */
	protected function execute($sqlQuery){
		$queryExecutor = new QueryExecutor();
		return $queryExecutor->execute($sqlQuery);
	}

	/**
	 * Execute export data
	 */
	protected function executeExport($name, $id){
		$queryExecutor = new QueryExecutor();
		return $queryExecutor->executeExport($name, $id);
	}	
		
	/**
	 * Execute sql query update
	 */
	protected function executeUpdate($sqlQuery){
		$queryExecutor = new QueryExecutor();		
		return $queryExecutor->executeUpdate($sqlQuery);
	}

}
?>