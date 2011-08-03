<?php

require_once(dirname(__FILE__) . "/Tadpole.php");

class View {

   protected $_tpl;

   public function __construct() {

      $this->_tpl = Tadpole::GetTemplate();

   }

   public function render($template, $data) {
      foreach($data as $key => $val) {
         $this->_tpl->assign($key, $val);
      }

      return $this->_tpl->fetch($template);
   }

}

