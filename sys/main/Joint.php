<?php
  class Joint {
    /*
    | Class for loading Join classes inside of the Kontroller scope.
    */

    //*************************************************************************

      public $handler = false;
      public $psm     = false;
      public $auth    = false;

    //*************************************************************************

    /*Construct function for supplying the PSM variable.*/
      public function __construct()
        {
          if (GLOBALS::EXIST('psm'))
            $this->handler = GLOBALS::GET('psm');
          else
            App::Error('no GLOBAL set (PSM_CONNECTION_VARS) set for connection to PSM in JOINT class');
          $this->psm = $this->handler;

          if (GLOBALS::EXIST('auth'))
            $this->auth    = GLOBALS::GET('auth');
        }

    /*Loading a specific Joint.*/
      public function __call($joint_name, $params)
        {
          return $this->Load( $joint_name );
        }

    /*Specifically loading a Joint class.*/
      public function Load($joint_name)
        {
          $loc = "app/joints/{$joint_name}Joint.php";
          if ( file_exists($loc) )
            include_once( $loc );

          return load_class( $joint_name."Joint" );
        }

  }
