<?php

class Contest
{
	private $contestnumber;

	private $contestname; 

	private $conteststartdate;

	private $contestduration;

	private $contestactive

	public function setContestNumber($contestnumber){
		$this->contestnumber = $contestnumber;
	}
	public function getContestNumber(){
		return $this->contestnumber;
	}

	public function setContestName($contestname){
		$this->contestname = $contestname;
	}
	public function getContestName(){
		return $this->contestname;
	}

	public function setContestStartDate($conteststartdate){
		$this->conteststartdate = $conteststartdate;
	}
	public function getContestStartDate(){
		return $this->conteststartdate;
	}

	public function setContestDuration($contestduration){
		$this->contestduration = $contestduration;
	}	
	public function getContestDuration(){
		return $this->contestduration;
	}

	public function setContestActive($contestactive){
		$this->contestactive = $contestactive;
	}

	public function getContestActive(){
		return $this->contestactive;
	}		

}

?>
