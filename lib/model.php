<?php

require_once("MDB2.php");

class Model {

   protected $_db;

   public function __construct($dsn) {
      $this->_db =& MDB2::connect($dsn);

      if(PEAR::isError($this->_db)) {
         die($this->_db->getMessage());
      }
   }

   public function db() {
      return $this->_db;
   }

}

