<?php
# require_once 'PHPUnit/Autoload.php';
# require(__DIR__ . '/../src/ExecutableRunner.class.php');
# require(__DIR__ . '/../src/Submission.class.php');
# require(__DIR__ . '/../src/Judge.class.php');


class ExecutableRunnerTest extends PHPUnit_Framework_TestCase
{
    public function testExecute_PlainSystemCommand()
    {
	$submission = new Submission();
	#$submission->setWorkDir(tempnam(sys_get_temp_dir(), 'test'));
	#$runner = new ExecutableRunner($submission);
	#$result = $runner->execute('/usr/bin/ls');
        #$this->assertEquals(0, $result);
        $judge = new Judge();
      	$judge->judge2('/home/guilherme/Documentos/PHP_Projeto/',$submission,'Prime');

    }

}
?>
