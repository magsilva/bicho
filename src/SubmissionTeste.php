<?php
	require_once(__DIR__ . '/DaoFiles/includeDAO.php');
	$submissionDAO = new SubmissionDAO();
	//$objSubmission = $submissionDAO->read(2,1,1); //contestes, runnumber, problemnumber
	//var_dump($objSubmission);
	$readAll = $submissionDAO->readAllNotJudged(2); //contestes, runnumber, problemnumber
	var_dump($readAll);
	//$save = $submissionDAO->saveResult("error message", 2, 6); //contestes, runnumber, problemnumber

?>
