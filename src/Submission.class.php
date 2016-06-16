<?php

class Submission
{
	private $nameFile;

	private $team; 

	public $workDir;

	private $language;

	private $contestNumber;

	private $runNumber;

	private $notjudge; //essa variavel é um array de objetos contendo várias submissions

	private $dataJudged;

	public function setWorkDir($workDir){
		$this->workDir = $workDir;
	}
	public function getWorkDir(){
		return $this->workDir;
	}

	public function setNameFile($nameFile){
		$this->nameFile = $nameFile;
	}
	public function getNameFile(){
		return $this->nameFile;
	}

	public function setTeam($team){
		$this->team = $team;
	}
	public function getTeam(){
		return $this->team;
	}

	public function setLanguage($language){
		$this->language = $language;
	}	
	public function getLanguage(){
		return $this->language;
	}

	public function setContestNumber($contestNumber){
		$this->contestNumber = $contestNumber;
	}

	public function getContestNumber(){
		return $this->contestNumber;
	}		


	public function setRunNumber($runNumber){
		$this->runNumber = $runNumber;
	}

	public function getRunNumber(){
		return $this->runNumber;
	}	

	public function setNotjudge($notjudge){
		$this->notjudge = $notjudge;
	}

	public function getNotjudge(){
		return $this->notjudge;
	}	

	public function setDataJudged($dataJudged){
		$this->dataJudged = $dataJudged;
	}

	public function getDataJudged(){
		return $this->dataJudged;
	}	
}


?>
