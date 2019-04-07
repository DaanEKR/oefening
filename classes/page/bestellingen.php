<?php
class page 
{
     
     public function __construct() 
     {
          //Call the databaseconnection
          $this->connection = database::connect();
     }
     
     public function getHtml() 
     {	
          if (isset($_GET['action'])) 
          {
               if ($_GET['action'] == "nieuw") 
               {
                    $_SESSION['bestellingen']['tafelnummer'] = '-1';
                    header("Location: bestellingen.php");
               }
               
               if ($_GET['action'] == "add") 
               {
                    $this->save();
                    header("Location: bestellingen.php");				
               }
          }
          $output = $this->getGerecht();
          return $output;
     }
     
     protected function getMenuitem($menuitemcode) 
     {
          $sql = "SELECT * FROM menuitem WHERE menuitemcode = '$menuitemcode'";
          foreach ($this->connection->query($sql) as $row) 
          {

               $aOutput = $row;
          }
          return $aOutput;
     }
     
     
     protected function save() 
     {
          // insert one row
          $tafel 			= $_SESSION['bestellingen']['tafelnummer'];
          $reservering_id	= $_SESSION['bestellingen']['reserveringsnummer'];
          var_dump($reservering_id);
          $datum 			= date("Y-m-d");
          $tijd 			= date("H:i:s");
          $menuitemcode 		= $_GET['item'];
          $aMenuitem 		= $this->getMenuitem($menuitemcode);
          $aantal 			= 1;
          $prijs 			= $aMenuitem['prijs'];

          $sql = "INSERT INTO bestelling 
                              (reservering_id, tafel, datum, tijd, menuitemcode, aantal, prijs) 
                       VALUES ($reservering_id, $tafel, '$datum', '$tijd', '$menuitemcode', $aantal, $prijs)";

          if (!($this->connection->query($sql) == true))
		{    print $sql . " Mislukt"; die;
		}
     }
     
     protected function getGerecht() 
     {
          $output = "";
          //GERECHT
          
          foreach($this->connection->query('SELECT * FROM gerecht') as $rowgerecht) 
          {
              $output .= 
                   "<div class='row'><h3>" . $rowgerecht['gerechtnaam'] . "</h3>";
                         
              //SUBGERECHT
              foreach ($this->connection->query('SELECT * FROM subgerecht') as $rowsubgerecht) 
              {
                   if ($rowgerecht['gerechtcode'] == $rowsubgerecht['gerechtcode']) 
                   {
                        $output .= "
                        <div class='col-xs-2 col-md-2'><h>" . $rowsubgerecht['subgerechtnaam'] . "</h>";
                         
                        //MENUITEM
                        foreach ($this->connection->query('SELECT * FROM menuitem') as $rowmenuitem) 
                        {
                             if ($rowsubgerecht['subgerechtcode'] == $rowmenuitem['subgerechtcode']) 
                             {
                                  $output .= "
                              <a href='?action=add&item=" . $rowmenuitem['menuitemcode'] ."'>"
                               . $rowmenuitem['menuitemnaam'] 
                           . "</a><br />";
                             }
                        }   	
                        $output .= "
                              </div>"; //end div subgerecht
                   }
              }
              $output .= "
                    </div>"; //end div gerecht
          }			
          return $output;
     }		
}