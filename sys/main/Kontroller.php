<?php
  class Kontroller {
    /*
      KONTROLLER
      Kontroller Class.

      Manages the Kontrollers (First method of call from Router)

      NEW UPDATED KONTROLLER INFORMATION:
        New Kontroller has the Router manage the KONTROLLER to call,
        AND the METHOD to call.
        New Kontroller also runs off of Kontroller full names,
        So, IndexKontroller instead of the old "Index" which turns
        into IndexKontroller later.
    */

    //*******************************************************************************

      // The current used Kontroller.
      public $_CURRENT_KONTROLLER = false;
      // The method name that's called when the method wanted to call doesn't exist.
      public $Kontroller_Fallback_Method_Name = 'index';

      public $Kontroller_Class = false;
      public $Kontroller_Name  = false;

      // The location for your Kontrollers.
      public $Kontroller_Locations = 'app/kontrollers/';

      // OPTIONS METHOD WAS DEPRECATED.
      // NOW IF HEADER WANT, LOAD FROM INDEX OR CREATE METHOD FOR TOP LOAD THEN BOTTOM LOAD.
      // SIMPLY $this->loader->entry->load('templates/Heade') [YOUR PAGE] $this->loader->entry->load('templates/Footer');

      /*
      | The class accessor for the classes of this class.
      | >>> $this->loader->psm->query(1, 2);
      */
      public $loader = [];

    //*******************************************************************************

    /*Constructor.*/
      public function __construct()
        {
          $this->KontrollerClassLoader();
        }


      // The information the router sends to the Kontroller class to manage.
      public function RouterKontrollerLoader($kontroller, $method = false, $dynamic = false)
        {
          $kontroller_feedback = $this->KontrollerExists_Information( $kontroller );
          if ( $kontroller_feedback[0] === false )
            App::Error("<b>Router -> RouterKontrollerLoader</b>", "Tried to load Kontroller {$kontroller} but FILE not found, looking for: <b>{$kontroller_feedback[1]}</b>.");
          else
            {
              // Loading the Kontroller and loading methods.
              require_once( $kontroller_feedback[1] );

              // Managing the location for the Kontroller file to get the actual Kontroller name.
              $kontroller = $this->ManageKontrollerName( $kontroller );

              // Setting class references & Sets.
              $_CURRENT_KONTROLLER = new $kontroller;
              $this->_CURRENT_KONTROLLER = $_CURRENT_KONTROLLER;


              // Dynamic manager.
              if ($dynamic)
                {
                  /*
                  | Dynamic load.
                  |
                  | We give the function the user has mapped to the slug the paramaters they need.
                  | First paramater = Slug2, Third paramater = Slug3, etc...
                  */
                  $method = $method;
                  $parms  = Url::GetSegmentsFrom(1);
                }
              else
                {
                  /*
                  | Un-Dynamic load.
                  |
                  | We load the function the user wants from the second paramater, meaning:
                  | /kontroller/method/parm-1-for-method/parm-2-for-method.
                  */
                  $method = Url::Second();
                  $parms  = Url::GetSegmentsFrom(2);
                }

                // To call the method the user wants requested, or call the "fallback" function.
                if ( method_exists( $_CURRENT_KONTROLLER, $method ) )
                  $_CURRENT_KONTROLLER->$method( $parms );
                else if ( method_exists( $_CURRENT_KONTROLLER, $this->Kontroller_Fallback_Method_Name ) )
                  {
                    $method = $this->Kontroller_Fallback_Method_Name;
                    $_CURRENT_KONTROLLER->$method( $parms );
                  }
                else App::Error('KontrollerLoader -> Load Fallback Method', "Kontroller {$kontroller} could not load wanted method OR fallback method. To set the Fallback Method name change the variable name in the Kontroller class.");
            }

        }
      // End of Router call manager.




      // IPTs The raw Kontroller name and returns what the Kontroller Class name will be.
      public function ManageKontrollerName($kontroller_name)
        {
          // Manipulation of the Kontroller name before creating the class instance. Output = The Kontroller Class name.

          $parts = explode( '/', $kontroller_name );
          $kontroller_name = $parts[ count($parts) - 1 ];

          return $kontroller_name;
        }
      // Gets the information on the Kontroller Name that's useful.
      // Current format: [ LOCATION_REAL, KONTROLLER_FILENAME, KONTROLLER_RAW_NAME ]
      public function KontrollerExists_Information( $kontroller_name )
        {
          // Checks if the Kontroller is existant, if so, will return an array of data for the Kontroller.
          $kontroller_locations = $this->Kontroller_Locations;
          $kontroller_filename  = $kontroller_locations . $kontroller_name . '.php';
          if ( file_exists( $kontroller_filename ) )
            {
              return [ true,  $kontroller_filename, $kontroller_name ];
            }
          else
            {
              return   [ false, $kontroller_filename, $kontroller_name ];
            }
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
          | > $this->loader->class_accessor = class_reference_instance.
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

          $loader = new KontrollerClassManager( $classes );
          $this->loader = $loader;
        }






    /*After running the class, will close the class from being accessed again.
    -Should be used after set the class variables and don't need to access anymore.
    -Run when no need of class variables.*/
      public function finish()
        {
          $this->loader = null;
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
















  // Our Class Loader.
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
          |
          | We're supplied with array with [class_name => class_instance]
          */

          $this->classes = $classes_reference_grid;
        }

      public function __get($class_name)
        {
          if (isset( $this->classes[$class_name] )) return $this->classes[$class_name];
            else App::Error("KontrollerClassManager Error", "Could not find the class <b>{$class_name}</b> requested from a Kontroller. <i>\$this->loader->{$class_name} NOT EXIST</i>");
        }

      public function __call($class_to_access, $params)
        {
          return $this->classes[$class_to_access];
        }
    }
