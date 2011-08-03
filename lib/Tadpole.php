<?php

require_once("router.php");
require_once("controller.php");
require_once("model.php");
require_once("view.php");
require_once("response.php");
require_once("Smarty/libs/Smarty.class.php");

class Tadpole {

   protected $_layout_tpl;
   protected $_controller;
   protected $_model;

   public $router;
   
   /**
    * Der Konstruktor
    */
   public function __construct() {

      $this->_layout_tpl = Tadpole::GetTemplate();
      $this->router      = new Router();

      $this->setupRoutes();
      $this->setupDatabase();

   }

   public function set_db_connection($dsn) {
      $this->_model = new Model($dsn);
   }

   public function db() {
      return $this->_model->db();
   }

   public function run() {
      $route = $this->router->get_route();

      if(!$route) {
         Header("HTTP/1.0 404 Not Found");
         Header("Status: 404", true);

         return "Page not found.";
      }

      $controller_name = ucfirst($route["controller"]) . "Controller";
      $controller_file = "app/controller/" . $route["controller"] . ".php";
      include_once($controller_file);


      $this->_controller = new $controller_name($this);

      $this->_controller->stash($_REQUEST);

      if($_SESSION)
         $this->_controller->stash($_SESSION);

      $method = $route["method"];
      $render_object = $this->_controller->$method();

      $this->_layout_tpl->assign("content", "".$render_object);

      foreach ($this->_controller->get_stash() as $key => $val) {
         $this->_layout_tpl->assign($key, $val);
      }

      return $this->_layout_tpl->fetch("layouts/" . $this->_controller->get_layout() . ".html");
   }

   public static function GetTemplate() {

      $tpl = new Smarty();
      $tpl->left_delimiter = '[% ';
      $tpl->right_delimiter = ' %]';

      $tpl->template_dir = dirname(__FILE__) . "/../app/view";
      $tpl->compile_dir  = dirname(__FILE__) . "/../tmp/template_c";
      $tpl->cache_dir    = dirname(__FILE__) . "/../tmp/cache";

      return $tpl;

   }

}

