<?php
/**
 * Created by JetBrains PhpStorm.
 * User: johannesstichler
 * Date: 16.05.13
 * Time: 11:34
 * To change this template use File | Settings | File Templates.
 */
require_once 'app/controllers/authenticated_controller.php';
require_once dirname(__FILE__).'/../modells/neostat_temp.php';
require_once dirname(__FILE__).'/../modells/neostat.php';
class CreatStatController extends \StudipController{
	private $imgdata;
	function before_filter(&$action, &$args)
	{
		$this->flash = Trails_Flash::instance();
		// set default layout
		$layout = $GLOBALS['template_factory']->open('layouts/base');
		//$layout =  "ajax/layout";
		$this->set_layout($layout);
	}

	function index_action() {
		echo "Hier gibts nichts zu sehen";
	}

	function createStat_action() {
		$i = 0;
		try {
		while($id = neostat_temp::getFirst() AND $i < 100) {
			$stat_temp = new neostat_temp($id);
			$pageid = $stat_temp->id;
			$pageid = unserialize($pageid);
			$pageid = $pageid["auswahl"];
			$tag = mktime(0,0,1, date("m",$stat_temp->mkdate),date("d",$stat_temp->mkdate),date("Y",$stat_temp->mkdate));
			if(empty($pageid)) $stat = neostats::findBySql("url = ? AND day = ?", array($stat_temp->url, $tag));
			else $stat = neostats::findBySql("url = ? AND id = ? AND day = ?", array($stat_temp->url, $pageid, $tag));
			if(empty($stat)) {
				$stats = new neostats();
				$stats->url = $stat_temp->url;
				$stats->id = $pageid;
				$stats->count = 1;
				$stats->day = $tag;
				$stats->store();
				$this->imgdata[$stats->statid]['url'] = $stats->url;
				$this->imgdata[$stats->statid]['count'] = $stats->count;
				unset($stats);
			} else{
				$stats = new neostats($stat[0]->statid);
				$stats->count++;
				$stats->store();
				$this->imgdata[$stats->statid]['url'] = $stats->url;
				$this->imgdata[$stats->statid]['count'] = $stats->count;
				unset($stats);
			}
			$stat_temp->delete();
			$stat_temp->store();


		}
		} catch(Exception $ex) {
			$this->test = $ex;
		}
	}





}