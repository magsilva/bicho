<?php

interface SubmissionInterfaceDAO{
	
	/**
 	 * Download data database 
 	 */
	// public function export($path);

	/**
 	 * Delete record from table
 	 */
	public function delete();
	
	/**
 	 * Insert record to table
 	 *
 	 */
	public function insert();
	
	/**
 	 * Update record in table
 	 *
 	 */
	public function update();

	/**
 	 * Read record in table
 	 *
 	 */
	public function read();	
	
}
?>