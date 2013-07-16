<?php
/**
 * Created by JetBrains PhpStorm.
 * User: johannesstichler
 * Date: 07.05.13
 * Time: 15:22
 * To change this template use File | Settings | File Templates.
 */

class neostat_temp extends SimpleORMap{
	function __construct($id = null) {
		parent::__construct($id);
	}

	function getFirst() {
		$sql = "SELECT neostat_id FROM `neostat_temp` LIMIT 1";
		$db = DBManager::get()->prepare($sql);
		$db->execute();
		$temp = $db->fetch();
		if(empty($temp[0])) return false;
		else return $temp[0];
	}


}