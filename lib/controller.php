<?php

require_once("view.php");
require_once("model.php");

class Controller {

   protected $_view;
   protected $_layout = "main";
   protected $_stash = array();

   public $db;

   public function __construct($app) {
      $this->_view = new View();
      $this->db    = $app->db();
   }

   public function stash($vars) {
      foreach ($vars as $key => $val) {
         $this->_stash[$key] = $val;
      }
   }

   public function render($layout) {
      $content = $this->_view->render($layout . ".html", $this->get_stash());

      $resp = new Response();
      $resp->set_content($content);
      $resp->set_content_type("text/html; charset=UTF-8");

      return $resp;
   }

   public function set_layout($layout) {
      $this->_layout = $layout;
   }

   public function get_layout() {
      return $this->_layout;
   }

   public function get_stash() {
      return $this->_stash;
   }

}

