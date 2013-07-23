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
		$log->url = $this->getPage();
		$log->id = $this->getId();
		$log->store();

	}

	function checklastlog() {
		$logs = neostat_temp::findbySQL("statid = '".$_SESSION["statid"]."' AND url = '".$this->getPage()."' AND id ='".$this->getId()."'");
		$time = mktime(date("H"),date("i")+5,date("s"),date("m"),date("d"),date("Y"));
		$newlog = true;
		foreach($logs as $l) {
			$timethen = mktime(date("H", $l["mkdate"]),date("i", $l["mkdate"])+5,date("s", $l["mkdate"]),date("m", $l["mkdate"]),date("d", $l["mkdate"]),date("Y", $l["mkdate"]));
			if($timethen < $time) $newlog = false;
		}
		return $newlog;
	}

    function getId() {
        if($_SERVER['PHP_SELF'] == '/dispatch.php') {
            if(strpos($_SERVER['PATH_INFO'], 'delete')) $id = 'Es wurde etwas geloescht'; //Es sollte nicht alle wissen was gemacht wurde
            else $id = $_SERVER['PATH_INFO'];

        } else $id = serialize($_GET);
        return $id;
    }

    function getPage() {
        switch($_SERVER['PHP_SELF']) {
            case '/plugins.php':
                return substr($_SERVER['PATH_INFO'],0,strpos($_SERVER['PATH_INFO'], '/',2));

            default: return $_SERVER['PHP_SELF'];
        }
    }




}