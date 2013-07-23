<?php
require_once dirname(__FILE__).'/../modells/neostat.php';
require_once dirname(__FILE__).'/../assets/php/jpgraph/src/jpgraph.php';
require_once dirname(__FILE__).'/../assets/php/jpgraph/src/jpgraph_line.php';


class showStatController extends \StudipController{

	function before_filter(&$action, &$args)
	{
		$this->flash = Trails_Flash::instance();
		// set default layout
		$layout = $GLOBALS['template_factory']->open('layouts/base');
		//$layout =  "ajax/layout";
		$this->set_layout($layout);
	}

	function index_action() {
		if(true) {
			$this->kwdata = $this->getStats();
			$this->creatLineKw();
		} else {
			echo "error kein Root";
		}


	}

	function getStats() {
		$return = array();
		$stats = neostats::findbysql("url IS NOT NULL");
		$gzugriffe = 0;
		foreach($stats as $s) {
			$kw = date("W", $s['day']);
			$return[$kw]['kw'] = $kw;
			if(empty($s->id)) $s->id = "keine";
			$return[$kw]['data'][] = array("url"=>$s->url,"id"=>$s->id,"titel"=>$s->seitenname,"zugriffe"=>$s->count);
			$return[$kw]['zugriffe'] += $s->count;
		}
		return $return;
	}

	function creatLineKw() {
		foreach($this->kwdata as $c) {
			$data[] = $c['zugriffe'];
		}
		$datay = array(20,15,33,5,17,35,22);

		// Setup the graph
		$graph = new Graph(400,200);
		$graph->SetMargin(40,40,20,30);
		$graph->SetScale("intlin");
		$graph->SetMarginColor('darkgreen@0.8');

		$graph->title->Set('Anzahl Zugriffe');
		$graph->yscale->SetAutoMin(0);

		// Create the line
		$p1 = new LinePlot($data);
		$p1->SetColor("blue");
		$p1->SetWeight(0);
		$p1->SetFillGradient('red','yellow');

		$graph->Add($p1);

		// Output line
		//$graph->Stroke(dirname(__FILE__).'../assets/img/auto/zugriffe.png');
		$graph->Stroke(dirname(__FILE__).'/../assets/img/auto/zugriffe.png');
	}

}