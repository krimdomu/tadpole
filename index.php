<?php

ini_set("include_path", dirname(__FILE__) . "/lib:.:" . dirname(__FILE__) . "/lib/PEAR" );

// Einstiegsdatei
// ---------------

require_once("lib/Tadpole.php");
require_once("app/MyApp.php");
require_once("app/controller/application_controller.php");

$app = new MyApp();
$resp = $app->run();

echo $resp;

?>
