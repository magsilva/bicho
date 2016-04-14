<?php
require_once(__DIR__ . '/submissionDaoFiles/includeDAO.php');

class SubmissionDAO{

	public $objectDAO;

	function SubmissionDAO(){
		$submissionDAO = new SubmissionPostgresDAO();
		$object = $submissionDAO->read(1,5,2); //contestes, runnumber, problemnumber
		$this->objectDAO = $object->getAnswer();

	}

	function checkIsZip($path){
		if(is_resource($zip = zip_open($path))){
			zip_close($zip);
			return TRUE;
		}
		return FALSE;
	}

	function unzip($file_to_unzip){
		$arqz = new ZipArchive();
		$arqz->open($file_to_unzip);
		$arqz -> extractTo($this->objectDAO["main_path"]); 
		$arqz -> close();
	} 
}

$teste = new SubmissionDAO();

if($teste->checkIsZip($teste->objectDAO["submission_problem_path"])){
	$teste->unzip($teste->objectDAO["submission_problem_path"]);
}
if($teste->checkIsZip($teste->objectDAO["problem_path_input"])){
	$teste->unzip($teste->objectDAO["problem_path_input"]);
}

?>