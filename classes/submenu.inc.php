<?php
	
class submenu 
{
     
     public function getHtml() 
     {
          $page = PAGE;
          switch(PAGE) 
          {
               case "index"			: 
               case "bestellingen"		:
               case "reserveringen"	:
              case "reserveringenvandaag":
               case "overzichten"		: 
               case "gegevens"		: $output = $this->$page(); break;
               default				: $output = $this->index();
          }
          return $output;
     }
     
     protected function index() 
     {
          $output = '
               <ul><li class="nobullet"><p>
                    Welkom bij de reserverings- en bestellingenapplicatie van Restaurant Excellent Taste.
               </p>
               <p> 
                    Vul eerst een reservering in. Deze kan telefonisch binnenkomen of kan worden 
                    ingevoerd als gasten plaatsnemen aan een vrije tafel.
               </p>
               <p>
                    Daarna kan een bestelling worden opgenomen.
               </p></li></ul>			
          ';
          return $output;
     }
     
     protected function bestellingen() 
     {
          include_once(CLASSES_PATH . "misc/bestelling.inc.php");
          $objBestelling = new bestelling;
          $output = $objBestelling->getBestelling();
          return $output;
     }
     
     protected function reserveringen() 
     {
          $output = '
               <ul>
                    <li class="nobullet">
                         <a href="?action=add">
                              <i class="fa fa-plus fa-5x" aria-hidden="true"></i>
                         </a>
                    </li>				
               </ul>			
          ';
          return $output;
     }
    protected function reserveringenvandaag()
    {
        $output = '
               <ul>
                    <li class="nobullet">
                         <a href="?action=add">
                              <i class="fa fa-plus fa-5x" aria-hidden="true"></i>
                         </a>
                    </li>				
               </ul>			
          ';
        return $output;
    }
     
     protected function overzichten() 
     {
          $output = "Onbekend overzicht";
          if (isset($_GET['overzicht'])) 
          {
               $output = "Overzicht voor " . $_GET['overzicht']; 
          }
          $output = "<h5>" . $output . "</h5>";
          return $output;
     }
     
     protected function gegevens() 
     {
          $output = "Onbekend onderhoud";
          if (isset($_GET['soort'])) 
          {
               $output = "Onderhoud " . $_GET['soort'];
          }
          $output = "<h5>" . $output . "</h5>";
          return $output;
     }
} 