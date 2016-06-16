<?php

class ProblemDAO implements SubmissionInterfaceDAO{


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
 	 * Update record in table
 	 *
 	 */
	public function read(){

	}
	/**
 	 * Faz um select tendo como retorno rundata e runfilename
 	 *
 	 * @param Numero do contest
 	 * @param numero do problema submetido (coluna:runnumber da tabela runtable)
 	 * @param Numero do pacote com entrada e saída do problema (coluna: problemnumber da tabela problemtable)

 	 */
	public function readProblem($contestnumber, $problemnumber){
		$sql = 'SELECT problemnumber, problemname, input, problemdescription, output '.
			   'FROM problemtable '.
			   'WHERE contestnumber = ? AND problemnumber = ?';
			   
		$sqlQuery = new SqlQuery($sql);					   
		$sqlQuery->setNumber($contestnumber);
		$sqlQuery->setNumber($problemnumber);

		$problem = new Problem();
		$problem->setContestNumber($contestnumber);		
		$problem->setProblemNumber($answerSql[0]->problemnumber);
		$problem->setProblemName($answerSql[0]->problemname);
		$problem->setInput($answerSql[0]->input);
		$problem->setProblemDescription($answerSql[0]->problemdescription);
		$problem->setOutput($answerSql[0]->output);
		return $problem;	
	}
 
	/**
 	 * Read record in table
 	 *
 	 */
	public function readAll($contestnumber){
		$sql = 'SELECT problemnumber '.
			   'FROM problemtable '.
			   'WHERE contestnumber = ?';
		$sqlQuery = new SqlQuery($sql);	
		$sqlQuery->setNumber($contestnumber);
		$answerSql = $this->execute($sqlQuery);
		
		$tab = array();
		foreach ($answerSql as $row) {
			$tab[] = $this->readProblem($contestnumber, $row->problemnumber);
		}
		$submission = new Submission();
		$submission->setNotjudge($tab);
		return $tab;
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