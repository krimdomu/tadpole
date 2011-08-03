<?php

class MyApp extends Tadpole {

   public function __construct() {

      parent::__construct();

   }

   public function setupRoutes() {

      $this->router->route("/", "welcome", "index");
      $this->router->route("/list", "welcome", "list_all");

   }

   public function setupDatabase() {

      $this->set_db_connection("mysqli://myuser:mypass@127.0.0.1/thedb");
         
   }

}


