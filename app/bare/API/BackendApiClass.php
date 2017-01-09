<?php
  class API
    {
      /*
      | The backend API to manage all requests.
      |
      | The main consept is a long array that contains slugs, and the GET slugs are equal to the third run.
      |
      | URI: /api/get/slug3
      | if SLUG3 == 'test', run the array function with the key of 'test'.
      |
      | There's going to be mainly the POST API and the GET API.
      */

      //******************************************************************************

        // IF POST_LOOKING = 'type', will look in $_POST['type'] for the POST slugs.
        public $POST_LOOKIN = 'type';
        public $psm         = false;

      //******************************************************************************

      public function __construct( $psm )
        {
          $this->psm = $psm;
        }


      // TRIGGERS AND ACTION RUNNING.

      // MANAGER FOR A GET INCOME.
      public function GET($torun_array)
        {
          if ( isset($torun_array[ Url::Third() ]) )
            {
              call_user_func( $torun_array[ Url::Third() ], $this );
              exit;
            }
        }
      // MANAGER FOR THE POST VALUES.
      public function POST($torun_array)
        {
          // Checks if there's the LOOKIN to get.
          if ( isset($_POST[ $this->POST_LOOKIN ]) ) $type = $_POST[ $this->POST_LOOKIN ];
            else return false;
          // Checks if the value of the LOOKIN is in the array.
          if ( isset($torun_array[ $type ]) )
            {
              call_user_func( $torun_array[ $type ], $this );
              exit;
            }
        }




      // EASY SANITIZATION.
      // All these functions are meant if you're using the JEK frontend framework
      // and have to sanitize the datab given to you.
      public function s($force = false)
        {
          if (!$force || !is_array($force)) $this->APIError('Sanitize function called [s()]', 'Please use a force filter array as the first paramater - nothing supplied');
          /*
          | This function is used if there is $('#form').serializeArray()
          */
          $force = array_merge(['token'], $force);
          // Makes sure thse PDATA is set.
          if (isset($_POST['pdata'])) $pdata = $_POST['pdata'];
          else $this->APIError('Sanitize [s()] function called', 'No PDATA given.');

          // Puts the pdata into the appropriate array.
          foreach ( $pdata as $index => $container )
            $data[ $container['name'] ] = $container['value'];
          // Data is retrieved.

          // Doing the force.
          $only_fields = array_keys( $data );
          foreach ($force as $index => $toforce)
            if ( $only_fields[ $index ] != $toforce )
              $this->APIError('Force was tried & fail', "Force failed: {$only_fields[$index]} NOT EQUAL {$toforce}");

          return $data;
        }






      // Simply prints out an easy-to-read message from the API when being alerted or console.log()'d.
      public function APIError($title, $message)
        {
          echo "$title\n\n$message";
          exit;
        }





      // Functions to speed up database entries and sanitization.
        public function check_table( $table, $specs )
          {
            // Check Table "TABLE" For "LOOKFOR" In "COLUMN"
            $column  = $specs['in'];
            $lookfor = $specs['for'];

            $statement = "SELECT * FROM {$table} WHERE {$column} = :look";
            $binds     = [':look' => $lookfor];

            $q = $this->psm->cquery( $statement, $binds );

            if ( $q->rowCount() != 0 )
              {
                // We need to return that there's currently a column with that data.
                $this->Return_Packer($specs['unique'], [
                  'html' => App::Alert( $specs['report'], 'warning' )
                ]);
                exit;
              }
          }


      // For when the API wants to return data to be publicised to the puller.
        public function Return_Packer($unique, $extra = false)
          {
            if ($extra !== false)
              $return = $extra;
            $return['return'] = $unique;
            echo json_encode( $return );
            exit;
          }
      // Returns error information with an alert.
        public function Error( $message )
          {
            $this->Return_Packer('error', [
              'html' => App::Alert($message, 'danger')
            ]);
            exit;
          }
      // Oops function to return a warning.
        public function Oops($message)
          {
            $this->Return_Packer('warning', [
              'html' => App::Alert($message, 'warning')
            ]);
            exit;
          }
      // When the calls are done and the API call was finished correctly.
        public function Success( $message )
          {
            $this->Return_Packer('success', [
              'html' => App::Alert( $message, 'success' )
            ]);
            exit;
          }


      //
    }
