<?php
  class Kontroller {
    /*
      KONTROLLER
      Kontroller Class.

      Manages the Kontrollers (First method of call from Router)
    */

    //*******************************************************************************

      public $Kontroller       = false;
      public $Kontroller_Class = false;
      public $Kontroller_name  = false;

      public $joint            = false;
      public $entry            = false;

      public $auth             = false;
      public $psm              = false;

    //*******************************************************************************

    /*Constructor.*/
      public function __construct()
        {
          $this->Kontroller = $this;
          $this->joint      = load_class('Joint');
          $this->entry      = load_class('Entry');
          $this->auth       = GLOBALS::GET('auth');
          $this->psm        = GLOBALS::GET('psm');
        }

    /*Loads a Kontroller.*/
      public function Load($kontroller_name)
        {
          if ( $kontroller_location = $this->Kontroller_Exists( $kontroller_name ) )
            include_once( $kontroller_location );
          else App::Error("load {$kontroller_name} - file not found");

          $this->Kontroller_Class = load_class( "{$kontroller_name}Kontroller" );
          $this->Kontroller_Name  = $kontroller_name;

          $first = Url::First();
          if ( method_exists($this->Kontroller_Class, $first) )
            $this->Kontroller_Class->$first();
        }

    /*Checks if a Kontroller exists.*/
      public function Kontroller_Exists($kontroller_name)
        {
          //Kontroller_ind  = Index of Kontroller, so (name - _Kontroller)
          //Kontroller_name = Real class name of Kontroller.
          $kontroller_ind   = $kontroller_name;
          $kontroller_name .= "_Kontroller";

          if ( file_exists( "app/kontrollers/{$kontroller_ind}Kontroller.php" ) )
            return "app/kontrollers/{$kontroller_ind}Kontroller.php";
          else return false;
        }


  }
