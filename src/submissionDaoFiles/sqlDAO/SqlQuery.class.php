<?php

class SqlQuery{
	var $txt;
	var $params = array();
	var $idx = 0;

	/**
	 * Constructor
	 *
	 * @param String consulta sql
	 */
	function SqlQuery($txt){
		$this->txt = $txt;
	}

	/**
	 * Set string param
	 *
	 * @param String $value value set
	 */
	public function setString($value){
		$value = pg_escape_string($value);
		$this->params[$this->idx++] = "'".$value."'";
	}
	
	/**
	 * Set string param
	 *
	 * @param String $value value to set
	 */
	public function set($value){
		$value = pg_escape_string($value);
		$this->params[$this->idx++] = "'".$value."'";
	}
	

	/**
	 * método converte os pontos de interrogação
	 * sobre o valor passado como um parâmetro do método
	 *
	 * @param String $value valor para inserir
	 */
	public function setNumber($value){
		if($value==null){
			$this->params[$this->idx++] = "null";
			return;
		}
		if(!is_numeric($value)){
			throw new Exception($value.' is not a number');
		}
		$this->params[$this->idx++] = "'".$value."'";
	}

	/**
	 * Get sql query
	 *
	 * @return String
	 */
	public function getQuery(){
		if($this->idx==0){
			return $this->txt;
		}
		$p = explode("?", $this->txt);
		$sql = '';
		for($i=0;$i<=$this->idx;$i++){
			if($i>=count($this->params)){
				$sql .= $p[$i];
			}else{
				$sql .= $p[$i].$this->params[$i];
			}
		}
		return $sql;
	}


}
?>