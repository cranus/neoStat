<?php
/**
 * Created by JetBrains PhpStorm.
 * User: johannesstichler
 * Date: 22.05.13
 * Time: 09:54
 * To change this template use File | Settings | File Templates.
 */
require_once dirname(__FILE__).'/../assets/php/jpgraph/src/jpgraph.php';
require_once dirname(__FILE__).'/../assets/php/jpgraph/src/jpgraph_line.php';
require_once dirname(__FILE__).'/../modells/neostat.php';
class createImage extends StudipController{

	private $imgdata;
	function before_filter(&$action, &$args)
	{
		$this->flash = Trails_Flash::instance();
		// set default layout
		$layout = $GLOBALS['template_factory']->open('layouts/base');
		//$layout =  "ajax/layout";
		$this->set_layout($layout);
	}

}