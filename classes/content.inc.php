<?php
	/**
	 * content class
	 */
	class content {
		//Open in de map /classes/page de bijbehorende file
		public function getHtml() {
		if(file_exists("classes/page/". PAGE . ".php")) {
				require_once("classes/page/". PAGE . ".php");
			} else {
				require_once("classes/page/index.php");
			}
			$page = new page;
			return $page->getHtml();
		}
	}
?>