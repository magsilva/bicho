<?php

class ContestDAO implements SubmissionInterfaceDAO{



	public function ContestDAO(){

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
 	 * @param numero do contesta submetido (coluna:runnumber da tabela runtable)
 	 * @param Numero do pacote com entrada e saída do contesta (coluna: contestnumber da tabela contesttable)

 	 */
	public function readContest($contestnumber){
		$sql = 'SELECT contestname, conteststartdate, contestduration, contestactive '.
			   'FROM contesttable '.
			   'WHERE contestnumber = ?';

		$sqlQuery = new SqlQuery($sql);					   
		$sqlQuery->setNumber($contestnumber);
		$sqlQuery->setNumber($contestnumber);

		$contest = new Contest();
		$contest->setContestNumber($contestnumber);		
		$contest->setcontestName($answerSql[0]->contestname);
		$contest->setContestStartDate($answerSql[0]->conteststartdate);
		$contest->setContestDuration($answerSql[0]->contestduration);
		$contest->setContestActive($answerSql[0]->contestactive);
		return $contest;	
	}
 
	/**
 	 * Read record in table
 	 *
 	 */
	public function readContestActivity(){
		$sql = 'SELECT contestnumber '.
			   'FROM contesttable '.
			   'WHERE contestactive = ?';
		$sqlQuery = new SqlQuery($sql);	
		$sqlQuery->setString('t'); //t=true or f=false, também pode utilizar 0 ou 1
		$answerSql = $this->execute($sqlQuery);
		
		$tab = array();
		foreach ($answerSql as $row) {
			$tab[] = $this->readContest($row->contestnumber);
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