<?php


class Router {

   protected $_route_db = array();

   public function __construct() {
   
   }

   public function route($route, $controller, $method) {
      $this->_route_db[$route] = array("controller" => $controller, "method" => $method);
   }

   public function get_route() {
      
      $url = parse_url($_SERVER['REQUEST_URI']);
      return $this->_route_db[$url['path']];

   }

}

