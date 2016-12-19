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

      //If the user changes this in their Class, will not display header/footer.
      public $RunHeaderFooter  = true;

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
          $kontroller_location = $this->Kontroller_Exists( $kontroller_name );
          // Checks if the file looking for exists.
          if ( $kontroller_location !== false )
            {
              //It exists, the return is: [LOCATION, NAME].

              include_once       "{$kontroller_location[0]}";
              $kontroller_name =   $kontroller_location[1];
            }
          else  App::Error("Kontroller '{$kontroller_name}' class file could not be found.", "Kontroller file <b>/app/kontrollers/{$kontroller_name}Kontroller.php</b> couldn't be found. Try checking that the file exists.");

          // Creating the class instance. [MAKE SURE TO NOT USE CONSTRUCT FUNCTIONS]
          $this->Kontroller_Class = load_class( "{$kontroller_name}" );
          $this->Kontroller_Name  = $kontroller_name;

          // Manager for if there is an options method. -- Options change the way the code is executed.
          // Example, if you put inside an options method "$this->RunHeaderFooter = false;" - No header/footer is loaded on that page.
          if ( method_exists( $this->Kontroller_Class, 'options' ) )
          $this->Kontroller_Class->options();


          // Checking that the user wants to use a header/footer load. -- Changeable in the options method.
          if ( $this->Kontroller_Class->RunHeaderFooter )
            {
              $this->BaseLoad('templates/Header');
              $this->LoadKontrollerMethod( $this->Kontroller_Class );
              $this->BaseLoad('templates/Footer');
            }
          else
            {
              $this->LoadKontrollerMethod( $this->Kontroller_Class );
            }
        }





    /*Function for loading a classes method.*/
      public function LoadKontrollerMethod($kontroller_class)
        {
          $mthd = Url::Second();

          // Manager for a 'always' method inside method.
          if ( method_exists( $kontroller_class, 'always' ) )
          $this->$kontroller_class->Always();

          // Manager for method wanting to be called.
          if ( method_exists( $kontroller_class, $mthd ) ) $kontroller_class->$mthd();
          else $kontroller_class->Index();
        }





    /*Base load for loading a Kontroller and only a Kontroller, for a class you know def. exists.
    BASE ALWAYS LOADS THE KONTROLLER THEN LOADS THE INDEX METHOD.*/
      public function BaseLoad($kontroller_name)
        {
          $kontroller_location = $this->Kontroller_Exists($kontroller_name);
          if ($kontroller_location !== false)
            {
              include_once "{$kontroller_location[0]}";
              $kontroller = new $kontroller_location[1];
              $kontroller->index();
            }
          else App::Error("BaseLoad fail <br/> Kontroller '<b>{$kontroller_name}Kontroller.php</b>' file not found.", "Please double check the input.");


          // $kontroller_name .= 'Kontroller';
          // include_once "app/kontrollers/{$kontroller_name}.php";
          // $k = new $kontroller_name;
          // $k->index();
        }





    /*Checks if a Kontroller exists.
    RETURNS: FALSE if not exist, [LOCATION, NAME] if exist.*/
      public function Kontroller_Exists($kontroller_name)
        {
          //Kontroller_ind  = Index of Kontroller, so (name - _Kontroller)
          //NOTE            = Kontrollers can be paths.
          //Kontroller_name = Real class name of Kontroller.

          //Splits by /, then gets the last one.
          $kontroller_parts = explode('/',$kontroller_name);
          $kontroller_ind   = $kontroller_parts[ count($kontroller_parts) - 1 ];

          //The actual location of the file trying to be loaded.
          $kontroller_file  = "{$kontroller_name}Kontroller.php";


          if ( file_exists( "app/kontrollers/$kontroller_file" ) )
            {
              return ["app/kontrollers/$kontroller_file","{$kontroller_ind}Kontroller"];
            }
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
          $classes['set']        = load_class( 'set' );
          $classes['str']        = load_class( 'String' );

          $classes['lessc']      = load_class( 'lessc' );
          $classes['super']      = load_class( 'SuperCrypt' );

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
