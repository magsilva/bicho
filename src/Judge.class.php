<?php
require_once(__DIR__ .'/Gcc.class.php');
require_once(__DIR__.'/Runner.class.php');
require_once(__DIR__.'/PHP-FineDiff/finediff.php');


 /** tipos de erros 
  * Resposta					Descrição
  * YES 						Seu programa foi aceito, e você receberá um balão da cor correspondente ao problema.
  * NO: Incorrect Output 		Também conhecido como Wrong Answer. Indica que seu programa respondeu incorretamente a algum(ns) dos testes dos 								juízes.
  * NO: Time-limit Exceeded 	A execução do seu programa excedeu o tempo permitido pelos juízes. Esse limite de tempo usualmente não é divulgado 									aos times e pode variar para cada problema.
  * NO: Runtime Error 			Durante o teste ocorreu um erro de execução (causado pelo seu programa) na máquina dos juízes. Acesso a posições 									irregulares de memória ou estouro dos limites da máquina são os erros mais comuns.
  * NO: Compilation Error 		Seu programa tem erros de sintaxe. Pode ser ainda que você errou o nome do problema ou linguagem no momento da 									submissão.
  * NO: Output Format Error 	Também conhecido como Presentation Error, indica que a saída do seu programa não segue a especificação exigida na 									folha de questões, apesar do "resultado" estar correto. Corrija para se adequar à especificação do problema.
  * NO: Contact Staff 			Você deve pedir a presença do pessoal de staff, pois algum erro incomum aconteceu.
 **/
 
 /**
  * return 1 -> successfully unpacked. or return -1 -> Error decompressing.
  * return 2 -> successfully compiled. or return -2 -> Compilation error.
  * return 4 -> successfully executed. or return -4 -> Runtime error (Time-limit Exceeded).
  * return 8 -> correct output. or return -8 -> Output Format Error. or return -9 -> Incorrect Output.
  * return default ->  Contact Staff
 **/
 
class Judge
{
	function judge() {
		// char funcao para desconpactar os arquivos para um diretório /etc/nomedoarq
		$allreturn = 1; 
		
		if($allreturn == 1){
			// Compilar usando GccCompiler
			$gcccompiler = new GccCompiler();
			$allreturn = $gcccompiler->compile(__DIR__. '/f91/', NULL, 'main');		
			if($allreturn == -2){
				echo " NO: Compilation Error\n";
				return $allreturn;
			}
		}
		if($allreturn == 2){
			// Executar usando Runner
			$runner = new Runner();
			$allreturn = $runner->execute(__DIR__ . '/f91/main', NULL, NULL, __DIR__ . '/f91/entrada_f91', './output.txt');
			if($allreturn == -4) {
				echo "NO: Time-limit Exceeded\n";
				return $allreturn;
			}
		}
		if($allreturn == 4){
			//Comparar resultado
			$allreturn =  $this->compareresult(__DIR__.'/f91/saida_f91', __DIR__.'/output.txt');
			if($allreturn == -8) {
				echo "NO: Output Format Error \n";
				return $allreturn;
			}
			else if($allreturn == -9){
				echo "NO: Incorrect Output \n";
				return $allreturn;
			}
		}			
		if($allreturn == 8){
			echo "YES\n";
			return $allreturn;
		}			
	}

	function compareresult($pathinput, $pathoutput){
		$finediff = new FineDiff();
		$input = fopen($pathinput, "r");
		$output = fopen($pathoutput, "r");

		while(!feof ($input)){
			$lineinp = fgets($input, 4096);
			$lineout = fgets($output, 4096);
			$opcodes = $finediff->getDiffOpcodes($lineinp, $lineout /*, default granularity is set to character */);
			for($i = 0; $i < strlen($opcodes); $i++){
				if($opcodes[$i] == 'i'){
					$i++;
					while($opcodes[$i]!= ':'){
						$i++;	
					}
					$i++;
					if($opcodes[$i]!= ' ' || $opcodes[$i]!= '\t' || $opcodes[$i]!= '\n'){
						return -8;
					}
					else{
						return -9;
					}
				}
				else if ($opcodes[$i] == 'd'){
					return -9;
				}
			}

		}
		return 8;
	}
}

$teste = new Judge();
$teste->judge();
?>
