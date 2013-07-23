<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Johannes
 * Date: 17.07.13
 * Time: 09:21
 * To change this template use File | Settings | File Templates.
 */
require_once dirname(__FILE__).'/../modells/neostat_temp.php';
require_once dirname(__FILE__).'/../modells/neostat.php';
require_once dirname(__FILE__).'/../modells/seminare.php';

class createStatCronJob  extends CronJob {
    public static function getName() {
        return 'NeoStatCronjob';
    }

    public static function getDescription() {
        return 'F&uuml;hrt die Tempor&auml;ren Daten zusammen und erstellt die Grafik';
    }

    public function execute($last_result, $parameters = array()) {
        $i = 0;
        try {
            while($id = neostat_temp::getFirst() AND $i < 100) {
                $stat_temp = new neostat_temp($id);
                $pageid = $stat_temp->id;
                If($stat_temp->url != '/dispatch.php') {
                    $pageid = unserialize($pageid);
                    if(isset($pageid["cid"])) $pageid = $pageid["cid"];
                    else $pageid = $pageid["auswahl"];
                }

                $tag = mktime(0,0,1, date("m",$stat_temp->mkdate),date("d",$stat_temp->mkdate),date("Y",$stat_temp->mkdate));
                if(empty($pageid)) $stat = neostats::findBySql("url = ? AND day = ?", array($stat_temp->url, $tag));
                else $stat = neostats::findBySql("url = ? AND id = ? AND day = ?", array($stat_temp->url, $pageid, $tag));
                if(empty($stat)) {
                    $stats = new neostats();
                    $stats->url = $stat_temp->url;
                    $stats->id = $pageid;
                    $stats->count = 1;
                    $stats->day = $tag;
                    $stats->seitenname = $this->getSiteName($stat_temp->url,$pageid);
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

    private function getSiteName($name, $id) {
        switch($name) {
            case 'sem_portal.php': return ""; break;
            case '/teilnehmer.php': $sem = new seminare($id);
                return 'Teilnehmerseite von '. $sem->Name; break;
            case '/index.php': return "Startseite"; break;
            case '/dispatch.php': return $id; break;
            case '/coreforum': $sem = new seminare($id);
                return 'Forum von '. $sem->Name; break;
            default: return "keinen Titel gefunden"; break;
        }

    }




}