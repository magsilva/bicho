<?php

class Problem {
	private $contestnumber;

	private $problemnumber; 

	private $problemname;

	private $input;

	private $problemdescription

	private $output;

	public function setContestNumber($contestnumber){
		$this->contestnumber = $contestnumber;
	}
	public function getContestNumber(){
		return $this->contestnumber;
	}

	public function setProblemNumber($problemnumber){
		$this->problemnumber = $problemnumber;
	}
	public function getProblemNumber(){
		return $this->problemnumber;
	}

	public function setProblemName($problemname){
		$this->problemname = $problemname;
	}
	public function getProblemName(){
		return $this->problemname;
	}

	public function setInput($input){
		$this->input = $input;
	}	
	public function getInput(){
		return $this->input;
	}

	public function setProblemDescription($problemdescription){
		$this->problemdescription = $problemdescription;
	}

	public function getProblemDescription(){
		return $this->problemdescription;
	}		

	public function setOutput($output){
		$this->output = $output;
	}

	public function getOutput(){
		return $this->output;
	}	
}

?>
