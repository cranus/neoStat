<?php
/**
 * Created by JetBrains PhpStorm.
 * User: johannesstichler
 * Date: 07.05.13
 * Time: 15:19
 * To change this template use File | Settings | File Templates.
 */
require_once 'app/controllers/authenticated_controller.php';
require_once dirname(__FILE__).'/../modells/neostat_temp.php';

class logthis extends \StudipController{
	function before_filter(&$action, &$args)
	{
		$this->flash = Trails_Flash::instance();
		// set default layout
		$layout = $GLOBALS['template_factory']->open('layouts/base');
		//$layout =  "ajax/layout";
		$this->set_layout($layout);

	}

	function log(){
		$log = new neostat_temp();
		$log->statid = $_SESSION["statid"];
		$log->url = $_SERVER['PHP_SELF'];
		$log->id = serialize($_GET);
		$log->store();

	}

	function checklastlog() {
		$logs = neostat_temp::findbySQL("statid = '".$_SESSION["statid"]."' AND url = '".$_SERVER['PHP_SELF']."'");
		$time = mktime(date("H"),date("i")+5,date("s"),date("m"),date("d"),date("Y"));
		$newlog = true;
		foreach($logs as $l) {
			$timethen = mktime(date("H", $l["mkdate"]),date("i", $l["mkdate"])+5,date("s", $l["mkdate"]),date("m", $l["mkdate"]),date("d", $l["mkdate"]),date("Y", $l["mkdate"]));
			if($timethen < $time) $newlog = false;
		}
		return $newlog;
	}


}