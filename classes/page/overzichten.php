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
          if (isset($_GET['overzicht'])) 
          {
               return $this->getOverzicht($_GET['overzicht']);
          }
          return "";
     }
     
     protected function getOverzicht($voorWie)
     {
          if ($voorWie == "kok")
          {    $selector = "<>";
          }
          else
          {    $selector = "=";
          };

          $vandaag = date("Y-m-d");
          $sql =($voorWie != "ober" ? "SELECT b.tafel, b.aantal, m.menuitemnaam FROM reservering r
                                                           LEFT JOIN bestelling b 
                                                                  ON r.reservering_id = b.reservering_id
                                                           LEFT JOIN menuitem m 
                                                                  ON b.menuitemcode = m.menuitemcode
                                                           LEFT JOIN subgerecht s 
                                                                  ON m.subgerechtcode = s.subgerechtcode
                   WHERE r.datum = '$vandaag'
                     AND s.gerechtcode " . $selector  . " 'drk'" : "SELECT b.tafel, b.aantal, m.menuitemnaam FROM reservering r
                                                           LEFT JOIN bestelling b 
                                                                  ON r.reservering_id = b.reservering_id
                                                           LEFT JOIN menuitem m 
                                                                  ON b.menuitemcode = m.menuitemcode
                                                            LEFT JOIN subgerecht s 
                                                                  ON m.subgerechtcode = s.subgerechtcode
                   WHERE r.datum = '$vandaag'
                     ");


          $output = "<table>
                          <thead>
                               <tr>
                                    <th>Tafel</th>
                                    <th>Aantal</th>
                                    <th>Gerecht</th>
                               </tr>
                          </thead>
                          </tbody>";
          
          foreach ($this->connection->query($sql) as $row) 
          {
             $output .= "      <tr>
                                    <td>" . $row['tafel'] . "</td>
                                    <td>" . $row['aantal'] . "</td>
                                    <td>" . $row['menuitemnaam'] . "</td>
                               </tr>"; 
          }
          $output .= "    </tbody>
                     </table>";
          return $output;
     }
          
}

