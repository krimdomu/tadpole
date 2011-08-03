<?php

class Response {

   protected $_header = array();
   protected $_content = "";

   public function __construct() {
   
   }

   public function add_header($key, $value) {
      $this->_header[$key] = $value;
   }

   public function set_content($content) {
      $this->_content = $content;
   }

   public function set_content_type($type) {
      $this->add_header("Content-Type", $type);
   }

   public function __toString() {
      foreach($this->_header as $key => $val) {
         Header("$key: $val");
      }

      return $this->_content;
   }

}

