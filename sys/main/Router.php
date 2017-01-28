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


        // All the characters that are allowed in the URL overall - More type-specific
        // forcing goes on later.
        public $force_charset = [
          '/', '-', '=', '_', ' ', '.',

          'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',
          'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p',
          'q', 'r', 's', 't', 'u', 'v', 'w', 'x',
          'y', 'z',
          'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H',
          'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P',
          'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X',
          'Y', 'Z',

          '0', '1', '2', '3', '4', '5', '6', '7', '8' ,'9'
        ];

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

      /*Method meant to sanitize the URL and make sure it's safe before proceeding.*/
        public function SanitizeUrl($options)
          {
            if (isset($options[0]) && $options[0] === false) return false;
            if (isset($options['force-characterset']) && $options['force-characterset'] === true)
              {
                // Will run over the URL making sure it conforms to the $this->force_charset array.
                $url = urldecode($_SERVER['REQUEST_URI']);
                foreach (str_split($url) as $url_char)
                if (!in_array("{$url_char}", $this->force_charset))
                App::Error('Sanitize Url (Overall Forcer)', "Illegal URL part <b>{$url_char}</b>");
              }

            // Now managing first and second forces.
            if (isset($options['first']))
              $this->Forcer( Url::Second(),
                $this->ForceRangler($options['first']['force-type'])
              );
            if (isset($options['second']))
              $this->Forcer( Url::Second(),
                $this->ForceRangler($options['second']['force-type'])
              );
          }

        // Takes in a numerative array and will convert keywords into arrays and combine.
        public function ForceRangler($force_types)
          {
            $types = [
              'LETTERS'  => array_merge(range('a','z'), range('A','Z')),
              'NUMBERS'  => range('0','9'),
              'SPECIALS' => ['-','=']
            ];
            // Roping all the forced content wanted.
            $rope = [];
            foreach ($force_types as $index => $type)
              if (in_array(strtoupper($type), array_keys($types)))
              $rope = array_merge($rope, $types[$type]);
            return $rope;
          }

        // Takes in a string and forces it to be any of the chars in the array.
        public function Forcer($forcing, $to_force)
          {
            foreach (str_split($forcing) as $index => $url_char)
              if (!in_array("{$url_char}", $to_force))
              App::Error('Sanitize URL (Slug Forcer)', "Illegal URL part <b>{$url_char}</b>");
          }









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
            if ( strtolower($call_type) == 'get' )
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
