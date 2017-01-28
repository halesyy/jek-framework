<?php
  class User
    {
      /*
      | Class meant to manage all your user data easily.
      | Public vars are changeable throughout the scope and
      | should be changed from this file, the constructor
      | will take in an ID and look in the base table for
      | the data.
      */

      //********************************************************

        public $base_table   = 'users';
        public $other_tables           = false;
        public $other_table_references = false;

        public $userid = false;
        public $base_data;

        public $psm = false;

      //********************************************************

      public function __construct($id = false)
        {
          if (!$id) App::Error('User class constructing', 'Class constructor not given an ID');
          $this->psm = Globals::Get('psm');
            if (is_numeric($id)) $this->userid = $id;
            else App::Error('User class constructing', 'Class ID not numeric - This is an ID based userclass');
          $this->fetch_base_table();
        }

      public function fetch_base_table()
        {
          $data = $this->psm->set( "SELECT * FROM {$this->base_table} WHERE id = :id", [':id' => $this->userid] );
          $this->base_data = $data;
        }

      public function __call($calling, $args)
        {
          $calling = strtolower($calling);
          return $this->base_data[$calling];
        }
    }
