<?php

// Simple management Script

ini_set("include_path", "./lib:.:" . "./lib/PEAR" );
require_once("lib/Tadpole.php");

function help() {

print "Tadpole v" . Tadpole::$VERSION . "\n";
print " create \$name     - Create a new Project\n";

}

if(sizeof($argv) == 1) {
   help();
   exit;
}

if($argv[2] == "create") {
   print "Creating new Project\n";
   mkdir "app";
   mkdir "app/controller";
   mkdir "app/view";
}

