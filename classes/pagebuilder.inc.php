<?php
class pagebuilder 
{
     
     public function __construct() 
     {
          $this->definePage();
          
          //Initialiseer: classes includen en er een instantie (object) van maken
          //Deze objecten worden later in de template gebruikt
          
          //<HEAD>
          require_once(CLASSES_PATH . "head.inc.php");
          $this->head = new head;
          
          //<CONTENT>
          require_once(CLASSES_PATH . "mainmenu.inc.php");
          $this->mainmenu = new mainmenu;
          require_once(CLASSES_PATH . "submenu.inc.php");
          $this->submenu = new submenu;
          require_once(CLASSES_PATH . "content.inc.php");
          $this->content = new content;
          
          //<FOOTER>
          require_once(CLASSES_PATH . "footer.inc.php");
          $this->footer = new footer;
          
          //OTHER			
          require_once(CONFIG_PATH . "database.inc.php");
     }
     
     private function definePage() 
     {
          // Hier wordt de URL bekeken en bepaald 
          //aan de hand van de paginanaam om welke pagina het gaat.
          //Vervolgens wordt deze CONSTANTE: PAGE in de verdere applicatie gebruikt 
          //om keuzes te maken.
          $url 	= $_SERVER['REQUEST_URI'];
          $page = pathinfo( parse_url( $url, PHP_URL_PATH ), PATHINFO_FILENAME );
          define("PAGE", $page);
     }
     
     public function getTemplate() 
     {
          switch(PAGE) 
          {
               case "bon": 
                    return "templateBlank"; 
                    break;
               default: 
                    return "templateDefault";
          }
     }
     
     public function templateDefault() 
     {
          $output = "";
          
          /**
           * This is the template for every requested page
           */
          $output .= 
               '<!DOCTYPE html>
                     <html>
                          <head>'.
                          $this->head->getHtml();	
          $output .=	'</head>
                          <body lang="nl">
                               <nav class="navbar navbar-default">
                                    <div class="container-fluid">
                                         <header>
                                              <div id="topbar"></div>';
          $output .=                               $this->mainmenu->getHtml();
          $output .=	               '</header>
                                         <content> 
                                              <div class="row"> 
                                                   <div class="col-xs-12 col-sm-4 col-lg-4">';
          $output .=                                    $this->submenu->getHtml();
          $output .=                         '</div>
                                                   <div class="col-xs-12 col-sm-8 col-lg-8">';
          $output .=                                    $this->content->getHtml();
          $output .=                              '</div>
                                              </div>
                                         </content>
                                         <footer>';
          $output .=                         '<hr />' .$this->footer->getHtml() .
                                        '</footer>
                                   </div>
                              </div>
                          </body>
                     </html>';
          
          //return the entire requested page
          return $output;
     }
     
     public function templateBlank() 
     {
          $output = "";
          
          /**
           * This is the template for every requested page
           */
          $output .= '<!DOCTYPE html>';
          $output .= '<html>';
               $output .= '<head>';
                    $output .= $this->head->getHtml();	
               $output .=	'</head>';
               
               $output .=	'<body lang="nl">';
               
                    $output .=	'<header>';
                         $output .= '<div id="topbar"></div>';
                         $output .= '<div id="bonheader">';
                              $output .= 'Restaurant Excellent Taste<br />';
                              $output .= 'Dorpstraat 13<br />';
                              $output .= '6188 AB Amsterdam<br />';
                              $output .= 'tel: 0613245388';
                         $output .= '</div>';
                    $output .= '</header>';
                    $output .= '<content>';
                              $output .= '<div class="col-xs-12 col-sm-12 col-lg-12">';
                                   $output .= $this->content->getHtml();
                              $output .= '</div>';
                         $output .= '</div>'; //end class=row
                    $output .=	'</content>';
                    
                    $output .=	'<footer>';
                         $output .= "<hr />" .$this->footer->getHtml();
                    $output .=	'</footer>';
                    
               $output .=	'</body>';
          $output .=	'</html>';
          
          //return the entire requested page
          return $output;
     }
}
?>