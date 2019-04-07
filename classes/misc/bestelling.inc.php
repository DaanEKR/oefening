<?php
	class bestelling {
		public function __construct() {
			//Call the databaseconnection
			$this->connection = database::connect();
		}
		
		public function getBestelling() {
			if(isset($_GET['reservering'])) {
				$_SESSION['bestellingen']['reserverings_id'] = $_GET['reservering'];
			}
			
			
			if(isset($_GET['action'])) {
				$action = $_GET['action'];
				switch($action) {
					case "plusitem"		: $this->plusitem(); break;
					case "minitem"		: $this->minitem(); break;
					case "deleteitem"	: $this->deleteitem(); break;
				}
				
			}
			
			if(isset($_SESSION['bestellingen']['reserverings_id'])) {
				if($_SESSION['bestellingen']['reserverings_id'] > 0) {
					
					$tafelnummer = $this->getTafelnummer();
					return $tafelnummer . $this->currentBestelling();
				}
			}
		}
		
		protected function getTafelnummer() {
			if(Isset($_GET['tafelnummer'])) {
				if($_GET['tafelnummer'] > 0) {
					$_SESSION['bestellingen']['tafelnummer'] = $_GET['tafelnummer'];
				}
			}
			$output = "Neem bestelling op voor tafel " . $_SESSION['bestellingen']['tafelnummer'];
			return $output;
		}
		
		private function getCurrentAantal() {
			$reservering_id 	= $_GET['reservering'];
			$menuitemcode 		= $_GET['menuitemcode'];
			$sql 				= "SELECT aantal FROM bestelling 
									WHERE reservering_id = '$reservering_id' 
									AND menuitemcode = '$menuitemcode'";
							
			$stmt 				= $this->connection->prepare($sql); 
			$stmt->execute(); 
			$row 				= $stmt->fetch();												
			$aantal 			= $row['aantal'];
			return $aantal;
		}
		
		
		private function plusitem() {
			$reservering_id = $_GET['reservering'];
			$menuitemcode = $_GET['menuitemcode'];
						
			$aantal = $this->getCurrentAantal();
			$aantal++;
			
			$sql = "UPDATE bestelling SET aantal = '$aantal' 
						WHERE reservering_id = '$reservering_id' 
						AND menuitemcode = '$menuitemcode'";
			if($this->connection->query($sql) == true) {
				return;
			} else {
				print $sql . " Mislukt"; die;
			}							
		}
		
		private function minitem() {
			$reservering_id = $_GET['reservering'];
			$menuitemcode = $_GET['menuitemcode'];
						
			$aantal = $this->getCurrentAantal();
			if($aantal >0) {
				$aantal--;
			} else {
				return;
			}
			
			$sql = "UPDATE bestelling SET aantal = '$aantal' 
						WHERE reservering_id = '$reservering_id' 
						AND menuitemcode = '$menuitemcode'";
			if($this->connection->query($sql) == true) {
				return;
			} else {
				print $sql . " Mislukt"; die;
			}			
		}
		
		private function deleteitem() {
			$reservering_id = $_GET['reservering'];
			$menuitemcode = $_GET['menuitemcode'];
			
			$sql = "DELETE FROM bestelling 
						WHERE reservering_id = '$reservering_id' 
						AND menuitemcode = '$menuitemcode'";
			if($this->connection->query($sql) == true) {
				return;
			} else {
				print $sql . " Mislukt"; die;
			}
		}
		
		
		private function currentBestelling() {
			$reserveringsID = $_SESSION['bestellingen']['reserverings_id'];
			
			$sql = "SELECT * FROM bestelling b, menuitem m 
							WHERE b.reservering_id = '$reserveringsID'
							AND b.menuitemcode = m.menuitemcode";

				$output = "<table>";
					$output .= "<thead>";
						$output .= "<tr>";
							
							$output .= "<th>";
								$output .= "Artikel:";
							$output .= "</th>";
							
							$output .= "<th>";
								$output .= "A";
							$output .= "</th>";
							
							$output .= "<th>";
								$output .= "";
							$output .= "</th>";
							
							$output .= "<th>";
								$output .= "";
							$output .= "</th>";
							
							$output .= "<th>";
								$output .= "";
							$output .= "</th>";
						$output .= "</tr>";
					$output .= "</thead>";
					
					$output .= "<tbody>";
				
					foreach($this->connection->query($sql) as $row) {
						$output .= "<tr>";
							$output .= "<td>";
								$output .= $row['menuitemnaam'];
							$output .= "</td>";	
							$output .= "<td>";
								$output .= $row['aantal'];
							$output .= "</td>";
							$output .= "<td>";
								$menuitemcode = $row['menuitemcode'];
								$output .= "<a href='bestellingen.php?action=plusitem&menuitemcode=$menuitemcode& reservering=$reserveringsID'><i class='fa fa-plus-circle' aria-hidden='true'></i></a>
";
							$output .= "</td>";
							$output .= "<td>";
								$output .= "<a href='bestellingen.php?action=minitem&menuitemcode=$menuitemcode& reservering=$reserveringsID''><i class='fa fa-minus-circle' aria-hidden='true'></i></a>
";
							$output .= "</td>";
											
							$output .= "<td>";
								$output .= "<a href='bestellingen.php?action=deleteitem&menuitemcode=$menuitemcode&reservering=$reserveringsID''><i class='fa fa-trash-o' aria-hidden='true'></i></a>
";
							$output .= "</td>";				
											
						$output .= "</tr>";
					}
			
			$output .= "</tbody>";
			$output .= "</table>";
			$output .= "<br />";
			$output .= "<a href='bon.php?reservering=$reserveringsID' class='btn btn-default' target='_blank'>Print bon voor klant";
			$output .= "</a>";
			return $output;
			
		}
	}	
?>