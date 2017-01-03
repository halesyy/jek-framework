<?php
  class Router
    {
      /*
      |----------------------------------------------------------------------------------
      | ROUTER
      |----------------------------------------------------------------------------------
      | The class that contains functionality for loading Kontrollers / Callbacks
      | depending on the slugs / index slug.
      |
      | Supports Get requests as well as Post requests.
      | Meaning this class can be used for managing POST requests.
      |----------------------------------------------------------------------------------
      */

      //*********************************************************************************

        public $Kontroller = false;
        public $CurSlug    = false;
        // The slug that has to be used first to trigger the API to be loaded.
        public $ApiTrigger = 'api';

      //*********************************************************************************

      /*Constructor to instanciate the Kontroller + the CurSlug (Current Slug).*/
        public function __construct()
          {
            $this->Kontroller = new Kontroller;
            $this->CurSlug    = Url::First();
          }

      /*
      | Using the Router2 from JEK framework,
      | we use an optional DYNAMIC or NODYANMIC set for loading slugs.
      |
      | The index slug is the first slug that occurs, and that's the
      | Kontrolelr to be called from map.
      |
      | So, for our first slug we call it and map it like so:
      | slugname@dynamic
      |
      | USING DYAMIC:
      | If the user is using a dynamic load for the function,
      | that means that the method being asked to call will be given
      | an array containing the next variables.
      |
      | [0 => second_slug, 1 => third_slug].
      |
      | NOT USING DYNAMIC:
      | If the user is not using a dynamic function loader, then:
      | /slug1/slug2 -- Kontroller mapped to slug1 calls the function slug2.
      */


      /*This is the recommended-to-use function to manage all incoming data.*/
        public function RouteMultipleInstances($slug_definitions)
          {
            // Checking for 404.
            if (!isset( $slug_definitions[ Url::First() ] ))
              App::Error_404();
            else $definitions = $slug_definitions[ Url::First() ];

            // Manager to set defaults as well as sets.
            if (isset($definitions['call'])) $to_call    = $definitions['call'];
            else $to_call = 'IndexKontroller@index';
            if (isset($definitions['when'])) $call_type  = strtolower($definitions['when']);
            else $call_type = 'get';
            if (isset($definitions['dynamic'])) $dynamic = $definitions['dynamic'];
            else $dynamic = false;

            // Managing the callable function if wanted.
            if (isset($definitions['callback']))
              {
                call_user_func( $definitions['callback'], $this->Kontroller );
                exit;
              }

            // GET MANAGER.
            if ( $call_type == 'get' )
              {
                // We're gonna have to load the Kontroller!
                $split_components = explode( '@', $to_call );
                if (count( $split_components ) == 1)
                { $kontroller_name = $to_call; $kontroller_method = 'index'; }
                else
                { $kontroller_name = $split_components[0]; $kontroller_method = $split_components[1]; }

                // $this->kontroller - Contains the Kontroller class.
                $this->Kontroller->RouterKontrollerLoader(
                  $kontroller_name,
                  $kontroller_method,
                  $dynamic
                );
              }
          }




    /*Function to accept the API to run.*/
      public function Api()
        {
          if ( Url::First() == $this->ApiTrigger )
            {
              App::Bare( 'API/BackendApi.php' );
              exit;
            }
        }










      #
    }
