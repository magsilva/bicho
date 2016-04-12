<?php
	require_once(__DIR__ . '/submissionDaoFiles/includeDAO.php');
	$submissionDAO = new SubmissionPostgresDAO();
	$objectDAO= $submissionDAO->read(1,5);
	var_dump($objectDAO->getAnswer());
?>