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
      public $Kontroller_Name  = false;

      /*
      | The class accessor for the classes of this class.
      | >>> $this->c->psm->query(1, 2);
      */
      public $c = [];

    //*******************************************************************************

    /*Constructor.*/
      public function __construct()
        {
          $this->KontrollerClassLoader();
        }

    /*Loads a Kontroller.*/
      public function Load($kontroller_name)
        {
          if ( $kontroller_location = $this->Kontroller_Exists( $kontroller_name ) )
            include_once( $kontroller_location );
          else App::Error("load {$kontroller_name} - file not found", "couldnt fund kontroller named {$kontroller_name}");

          $this->Kontroller_Class = load_class( "{$kontroller_name}Kontroller" );
          $this->Kontroller_Name  = $kontroller_name;

          $first = Url::Second();
          if ( method_exists($this->Kontroller_Class, $first) )
            $this->Kontroller_Class->$first();
          else $this->Kontroller_Class->Index();
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

    /*Loads classes you want to be loaded to "$kontroller->classes->some_class_you_want"*/
      public function KontrollerClassLoader()
        {
          /*
          | This is the file that sets the variables for class loading.
          |
          | All the $classes[CLASS_ACCESSOR] = CLASS_REFERENCE_INSTANCE's
          | are accessible from the class by doing:
          |
          | > $this->c->CLASS_ACCESSOR = CLASS_REFERENCE_INSTANCE.
          | >> Because -- They're stored in a mini-class containing a __call
          | >> magic method that's takes in the func name and uses that as
          | >> the call method.
          */
          $classes['psm']        = GLOBALS::GET('psm');
          $classes['auth']       = GLOBALS::GET('auth');
          $classes['kontroller'] = $this;
          $classes['joint']      = load_class( 'joint' );
          $classes['entry']      = load_class( 'entry' );

          $classes['lessc']      = load_class('lessc');

          $c = new KontrollerClassManager( $classes );
          $this->c = $c;
        }
    /*After running the class, will close the class from being accessed again.
    -Should be used after set the class variables and don't need to access anymore.
    -Run when no need of class variables.*/
      public function close_kontroller()
        {
          $this->c = null;
        }

    /*Loads multiple classes and returns their object references.*/
      public function load_classes($load_arr)
        {
          $ret = [];
            foreach ($load_arr as $class_name)
              $ret[$class_name] = $this->c->$class_name();
          return $ret;
        }
  }



  class KontrollerClassManager
    {
      public $classes = [];

      public function __construct($classes_reference_grid)
        {
          /*
          | C_R_G = Classes_reference_grid.
          | CRG contains the CRG[CLASS_NAME] = CLASS_INSTANCE,
          | so in a Kontroller you're able to call the
          | > $this->class->class_name->class_method,
          | >> by class = this-class, meaning when calling
          | >> a method in this class, its a __call, meaning
          | >> its treated as a string we can use to reference
          | >> the input class, return the string and give you
          | >> the class.
          */
          $this->classes = $classes_reference_grid;
        }

      public function __call($class_to_access, $params)
        {
          return $this->classes[$class_to_access];
        }
    }
