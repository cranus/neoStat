<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Johannes
 * Date: 17.07.13
 * Time: 09:24
 * To change this template use File | Settings | File Templates.
 */

class CronjobMigration extends Migration {
    function up() {
        $job_file = dirname(__FILE__).'../cronjobs/createStatCronJob.php';
        $task_id = CronjobScheduler::registerTask($job_file, true);

        // Schedule job to run 1 minute from now
        CronjobScheduler::scheduleOnce($task_id, strtotime('+1 minute'));

        // Schedule job to run every day at 23:59
        CronjobScheduler::scheduleRegular($task_id, 23, 59);
    }
}