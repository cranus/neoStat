<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'vendor/trails/trails.php';
require_once dirname(__FILE__).'/controllers/logthis.php';
/**
 *
 *
 * @author johannesstichler
 */
class neostat extends \StudipPlugin implements \SystemPlugin {

     function __construct()
    {
        parent::__construct();
        unset($GLOBALS["plugin_pfad"]);
        $this->flash = Trails_Flash::instance();
        $this->flash->vmurl = $this->getPluginURL();
        if(!isset($_SESSION["statid"])) $_SESSION["statid"] = md5(time());
	    if($perm = "root") {
		    $navigation = new Navigation("neo Statistik", PluginEngine::getURL($this, array(), "showStat/"));
		    Navigation::addItem('/start/neostat', $navigation);
	    }

	    $log = new logthis();
	    if($log->checklastlog()) $log->log();
    }
    
     /**
     * This method dispatches all actions.
     *
     * @param string   part of the dispatch path that was not consumed
     */
    function perform($unconsumed_path)
    {
        $trails_root = $this->getPluginPath();
        $dispatcher = new Trails_Dispatcher($trails_root, NULL, NULL);
        $dispatcher->dispatch($unconsumed_path);
    }

}

?>
