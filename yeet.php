<?php
    require_once("config/config.inc.php");
    require_once("classes/pagebuilder.inc.php");
    $objPage = new pagebuilder;
    $template = $objPage->getTemplate();
    echo $objPage->$template();
?>