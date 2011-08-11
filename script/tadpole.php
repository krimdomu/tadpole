<?php

// Simple management Script

ini_set("include_path", "./lib:.:" . "./lib/PEAR" . ":./lib/Smarty/libs" );
require_once("lib/Tadpole.php");

function help() {

print "Tadpole v" . Tadpole::$VERSION . "\n";
print " create \$name     - Create a new Project\n";

}

if(sizeof($argv) == 1) {
   help();
   exit;
}

if($argv[1] == "create") {
   if(! $argv[2]) {
      help();
      exit;
   }

   $name = $argv[2];

   print "Creating new Project\n";
   mkdir("app");
   mkdir("app/controller");
   mkdir("app/view");
   mkdir("app/view/layouts");
   mkdir("app/view/welcome");
   mkdir("public");
   mkdir("public/css");
   mkdir("public/js");
   mkdir("tmp");
   mkdir("tmp/cache");
   mkdir("tmp/template_c");

   $app_class = ucfirst(strtolower($name));

   $search = array(
      "{app_class}"
   );

   $replace = array(
      $app_class
   );

   file_put_contents("public/index.php", parse_template(
      $search,
      $replace,
      "index.php"
   ));

   file_put_contents("app/$app_class.php", parse_template(
      $search,
      $replace,
      "base_class"
   ));

   file_put_contents("app/controller/application_controller.php", parse_template(
      $search,
      $replace,
      "application_controller"
   ));

   file_put_contents("app/controller/welcome.php", parse_template(
      $search,
      $replace,
      "welcome_controller"
   ));

   file_put_contents("app/view/layouts/main.html", parse_template(
      $search,
      $replace,
      "main_layout"
   ));

   file_put_contents("app/view/welcome/index.html", parse_template(
      $search,
      $replace,
      "welcome_index"
   ));

   file_put_contents("public/.htaccess", parse_template(
      $search,
      $replace,
      ".htaccess"
   ));

   file_put_contents("public/css/master.css", parse_template(
      $search,
      $replace,
      "master.css"
   ));


   print "Project created.\n\n";
   print "Now point your DocumentRoot to the public folder of your new project.";
   print "And enable parsing of .htaccess files and mod_rewrite.\n";
   print "------\n";
   print "If you have questions just join irc.freenode.net #tadpole\n";
   print "------\n";

}

function parse_template($search, $replace, $tpl) {
   $content = get_template($tpl);

   $content = str_replace($search, $replace, $content);

   return $content;
}

function get_template($tpl) {
   $content = file(__FILE__);

   $in_tpl = 0;
   $tpl_content = "";
   foreach($content as $line) {
      $line = str_replace(array("\n", "\r"), array("", ""), $line);
      if($line == "@$tpl") {
         $in_tpl = 1;
         continue;
      }

      if($in_tpl) {

         if($line == "@end") {
            $in_tpl = 0;
            return $tpl_content;
         }


         $tpl_content .= $line . "\n";

      }
   }

}

/*

@index.php
<?php

chdir("..");
ini_set("include_path", "./lib:.:" . "./lib/PEAR" . ":./lib/Smarty/libs" );

require_once("lib/Tadpole.php");
require_once("app/{app_class}.php");
require_once("app/controller/application_controller.php");

$app = new {app_class}();
$resp = $app->run();

echo $resp;


@end

@base_class
<?php

class {app_class} extends Tadpole {

   public function __construct() {

      parent::__construct();

   }

   public function setupRoutes() {

      $this->router->route("/", "welcome", "index");

   }

   public function setupDatabase() {

      // $this->set_db_connection("mysqli://myuser:mypass@127.0.0.1/thedb");
         
   }

}

@end

@application_controller
<?php


class ApplicationController extends Controller {

   public function __construct($app) {
      parent::__construct($app);
   }

}

@end

@welcome_controller
<?php
class WelcomeController extends ApplicationController {

   public function index() {

      return $this->render("welcome/index");

   }

}

@end

@main_layout
<html>
   <head>
      <meta http-equiv="content-type" content="text/html; charset=utf-8">
   
      <title>Geruesst</title>
      <link rel="stylesheet" href="/css/master.css" type="text/css" media="screen" charset="utf-8">
   </head>
   <body>
      [% $content %]
   </body>
</html>
@end

@welcome_index
<h1>welcome#index</h1>

Hello [% $name %]
@end

@.htaccess
RewriteEngine On

RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ index.php [L]

@end

@master.css
*, html {
   margin: 10;
   padding: 10;
}
@end

*/


