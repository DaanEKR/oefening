<?php
	/**
	 * Require_once means you need these files to continu execute the code
	 */
	require_once("config/config.inc.php");
	
	/**
	 * You can find the constant CLASSES_PATH in the config file.
	 * It types the path instead of you doing: 
	 * require_once("classes/pagebuilder.inc.php");
	 */
	require_once(CLASSES_PATH . "pagebuilder.inc.php");
	
	/**
	 * The pagebuilder file is a class you can look at as it is your template for every page.
	 * This class is running for every request, so use it to do general things.
	 * In the code is only 1 echo to the screen. 
	 * Every output is returned to the parent object (pagebuilder).
	 */
	
	$objPage = new pagebuilder;
	$template = $objPage->getTemplate();
	echo $objPage->$template();
?>