<?php

class SubmissionDAO implements SubmissionInterfaceDAO{


	private $zipclass;

	public function SubmissionDAO(){
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

		$pathProblem = $this->executeExport($answerSql[0]->run_file_name, $answerSql[0]->run_data, $path);
		if($this->zipclass->check_is_zip($pathProblem)){
			$this->zipclass->unzip($pathProblem, $path);
		}

		$pathInputFile = $this->executeExport($answerSql[0]->problem_name_input, $answerSql[0]->problem_data, $path);	
		if($this->zipclass->check_is_zip($pathInputFile)){
			$this->zipclass->unzip($pathInputFile, $path);
		}
		$submission = new Submission();
		$submission->setWorkDir($path);
		$submission->setNameFile($answerSql[0]->run_file_name);
		$submission->setContestNumber($contestnumber);
		$submission->setRunNumber($runnumber);
		$submission->setLanguage($answerSql[0]->language);
		$submission->setTeam($answerSql[0]->team);
		return $submission;	
	}
 
	/**
 	 * Read record in table
 	 *
 	 */
	public function readAllNotJudged($contestnumber){
		$sql = 'SELECT runnumber, problemnumber '.
			   'FROM runtable as r, problemtable as p '.
			   'WHERE r.contestnumber= ? AND judgedata is null AND '.
			   'r.contestnumber= p.contestnumber AND r.runproblem = p.problemnumber';
		$sqlQuery = new SqlQuery($sql);	
		$sqlQuery->setNumber($contestnumber);
		$answerSql = $this->execute($sqlQuery);
		
		$tab = array();
		foreach ($answerSql as $row) {
			$tab[] = $this->read($contestnumber, $row->runnumber, $row->problemnumber);
		}
		$submission = new Submission();
		$submission->setNotjudge($tab);
		return $tab;
	}

	/**
 	 * Update record in table
 	 *
 	 */
	public function saveResult($submission, $result){
		$serialized_data = serialize($result);
		$sql = 'UPDATE runtable '.
			   'SET judgedata = ? '.
			   'WHERE contestnumber= ? AND runnumber = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($serialized_data);
		$sqlQuery->setNumber($submission->getContestNumber());
		$sqlQuery->setNumber($submission->getRunNumber());
		$answerSql = $this->executeUpdate($sqlQuery);
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

	/**
	 * Insert row to table
	 */
	protected function executeInsert($sqlQuery){
		return QueryExecutor::executeInsert($sqlQuery);
	}
}
?>