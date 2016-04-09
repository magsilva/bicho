<?php
	require_once(__DIR__ . '/submissionDaoFiles/includeDAO.php');
	$submissionDAO = new SubmissionPostgresDAO();
	$arrayInfo= $submissionDAO->read(1,5);
	var_dump($arrayInfo);
?>