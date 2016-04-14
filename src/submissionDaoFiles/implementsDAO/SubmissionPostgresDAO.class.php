<?php

class SubmissionPostgresDAO implements SubmissionInterfaceDAO{

	private $answerSql;

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
 	 * Faz um select tendo como retorno rundata e runfilename
 	 *
 	 * @param Numero do contest
 	 * @param numero do problema submetido (coluna:runnumber da tabela runtable)
 	 * @param Numero do pacote com entrada e saída do problema (coluna: problemnumber da tabela problemtable)

 	 */
	public function read($contestnumber, $runnumber, $problemnumber){
		$sql = 'SELECT r.rundata as run_data, r.runfilename as run_file_name, '.
			   'p.probleminputfilename as problem_name_input, p.probleminputfile as problem_data '.
			   'FROM runtable as r, problemtable as p '.
			   'WHERE r.contestnumber= ? AND r.runnumber = ? '.
			   'AND p.contestnumber= ? AND p.problemnumber= ?';
			   
		$sqlQuery = new SqlQuery($sql);					   
		$sqlQuery->setNumber($contestnumber);
		$sqlQuery->setNumber($runnumber);
		$sqlQuery->setNumber($contestnumber);
		$sqlQuery->setNumber($problemnumber);

		$this->answerSql = $this->execute($sqlQuery);	
		$path = $this->createDir();

		$pathProblem = $this->executeExport($this->answerSql["run_file_name"], $this->answerSql["run_data"], $path);	
		$pathInputFile = $this->executeExport($this->answerSql["problem_name_input"], $this->answerSql["problem_data"], $path);	

		$this->answerSql["main_path"] = $path;
		$this->answerSql["submission_problem_path"] = $pathProblem;
		$this->answerSql["problem_path_input"] = $pathInputFile;				
		return $this;		
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
	protected function executeExport($name, $id, $path){
		$queryExecutor = new QueryExecutor();
		return $queryExecutor->executeExport($name, $id, $path);
	}	
		
	/**
	 * Execute sql query update
	 */
	protected function executeUpdate($sqlQuery){
		$queryExecutor = new QueryExecutor();		
		return $queryExecutor->executeUpdate($sqlQuery);
	}

	protected function createDir(){
		$path = tempnam ("/tmp/", "problem");
		unlink($path);
		mkdir($path, 0755);
		return $path;
	}

	public function getAnswer(){
		return $this->answerSql;
	}
}
?>