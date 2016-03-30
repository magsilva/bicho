<?php
require_once(__DIR__ . '/db.php');
class SubmissionDAO
{
	function selectProblemDB($connection, $contest){
		$sql = "select r.contestnumber as contest, r.runsitenumber as site, r.runanswer as answer, " .
		"r.runanswer1 as answer1, r.runanswer2 as answer2, " .  
		"r.runnumber as number, r.rundatediff as timestamp, r.runstatus as status, " .
		"r.rundata as sourceoid, r.runfilename as sourcename, l.langnumber as langnumber, " .
		"p.problemname as problemname, p.problemnumber as problemnumber, l.langextension as extension, l.langname as language, " .
		"p.problembasefilename as basename, ".
		"p.probleminputfilename as inputname, p.probleminputfile as inputoid, " .
		"r.autoip as autoip, r.autobegindate as autobegin, r.autoenddate as autoend, r.autoanswer as autoanswer, ".
		"r.autostdout as autostdout, r.autostderr as autostderr ".
		"from runtable as r, problemtable as p, langtable as l " .
		"where r.contestnumber=$contest and p.contestnumber=r.contestnumber and " .
		"r.runproblem=p.problemnumber and r.runlangnumber=l.langnumber and ".
		"r.contestnumber=l.contestnumber and " .
		"r.autoip='' order by r.runnumber for update limit 1";

		$result = pg_query($connection, $sql) or die ('Query failed: '. pg_last_error() . "\n");

		return $result;
	}		

	function problemExport($id, $contest){
		$connection = DBConnect();
		$result = $this->selectProblemDB($connection, $contest);

		$result = DBRow($result, 0);
   		echo $result["contest"]."\n";
		echo $result["sourceoid"]."\n";
		echo $result["inputoid"]."\n";		
		echo $result["inputname"]."\n";
		echo $result["sourcename"]."\n";
		DBExec($connection, 'begin work', 'Autojudging(exporttransaction)');
		$stat= pg_lo_export ($result["sourceoid"], __DIR__ ."/".$result["sourcename"], $connection); //sourceid= programa submetido, inputid= problem.zip (o que o admin faz upload);
		DBExec($connection, 'rollback work', 'Autojudging(rollback-source)');
	}
}

$teste = new SubmissionDAO();

$teste-> problemExport(1, 1);

?>