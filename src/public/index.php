<?php
header("Content-type: text/html; charset=utf-8");
error_reporting(-1);
define('DIR_PATH', realpath(dirname(__DIR__ . '/../../')));
define("APPLICATION_PATH", DIR_PATH . '/Process');
define("CONF_PATH", DIR_PATH . '/conf');
define("VIEW_PATH", APPLICATION_PATH . '/views');

$application = new Yaf_Application(CONF_PATH . "/ApiProxy.ini");
$response    = $application->bootstrap()->run();
