<?php

require(__DIR__ . '/../src/ExecutableRunner.class.php');
require(__DIR__ . '/../src/Submission.class.php');

class ExecutableRunnerTest extends PHPUnit_Framework_TestCase
{
    public function testExecute_PlainSystemCommand()
    {
	$submission = new Submission();
	$submission->workDir = tempnam(sys_get_temp_dir(), 'test');
	$runner = new ExecutableRunner($submission);
	$result = $runner->execute('/usr/bin/ls');
        $this->assertEquals(0, $result);
    }
}
?>
