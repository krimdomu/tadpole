<?php

class WelcomeController extends ApplicationController {

   public function index() {

      $sth = $this->db->prepare("SELECT * FROM test WHERE id > ?");
      $res = $sth->execute(0);

      $this->stash(array("namen" => $res->fetchAll(MDB2_FETCHMODE_ASSOC)));

      return $this->render("welcome/index");

   }

   public function list_all() {
      return $this->render("welcome/list_all");
   }

}

