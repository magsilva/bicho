<?php

class SubmissionDAO implements SubmissionInterfaceDAO{


	private $submission;
	private $zipclass;

	public function SubmissionDAO(){
		$this->submission = new Submission();
		$this->zipclass = new Zipfiles();
	}
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
		$sql = 'SELECT  r.runlangnumber as language, r.rundata as run_data, r.runfilename as run_file_name, r.usernumber as team, '.
			   'p.probleminputfilename as problem_name_input, p.probleminputfile as problem_data '.
			   'FROM runtable as r, problemtable as p '.
			   'WHERE r.contestnumber= ? AND r.runnumber = ? '.
			   'AND p.contestnumber= ? AND p.problemnumber= ? AND r.runproblem = p.problemnumber';
			   
		$sqlQuery = new SqlQuery($sql);					   
		$sqlQuery->setNumber($contestnumber);
		$sqlQuery->setNumber($runnumber);
		$sqlQuery->setNumber($contestnumber);
		$sqlQuery->setNumber($problemnumber);

		$answerSql = $this->execute($sqlQuery);	
		$path = $this->zipclass->create_dir();

		$pathProblem = $this->executeExport($answerSql["run_file_name"], $answerSql["run_data"], $path);
		if($this->zipclass->check_is_zip($pathProblem)){
			$this->zipclass->unzip($pathProblem, $path);
		}

		$pathInputFile = $this->executeExport($answerSql["problem_name_input"], $answerSql["problem_data"], $path);	
		if($this->zipclass->check_is_zip($pathInputFile)){
			$this->zipclass->unzip($pathInputFile, $path);
		}

		$this->submission->setWorkDir($path);
		$this->submission->setNameFile($answerSql["run_file_name"]);
		$this->submission->setContest($contestnumber);
		$this->submission->setLanguage($answerSql["language"]);
		$this->submission->setTeam($answerSql["team"]);

		return $this->submission;	
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

}
?>