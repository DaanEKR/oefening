<?php
	class page {
		
		public function __construct() {
			//Call the databaseconnection
			$this->connection = database::connect();
		}
		
		public function getHtml() {			
			$output = "<div id='photohome'></div>";
		
			return $output;
		}	
	}