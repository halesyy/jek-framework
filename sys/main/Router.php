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

        protected $Kontroller = false;
        protected $CurSlug    = false;

      //*********************************************************************************

      /*Constructor.*/
        public function __construct()
          {
            $this->Kontroller = new Kontroller;
            $this->CurSlug    = Url::First();
          }

      /*For calling a Kontroller on slug match.*/
        public function On($slugname, $kontroller = false)
          {
            if ($kontroller === false) $kontroller = $slugname;
            if ( $this->CurSlug == $slugname )
              {
                $this->Load( $kontroller );
              }
          }

      /*For calling a callback on slug match.*/
        public function Get($slugname, callable $do)
          {
            if ( $this->CurSlug == $slugname )
              $do( new Kontroller );
          }

      /*Function to check for a post request that specifies that want.*/
        public function Post($slugname, callable $do)
          {
            $curslug = Url::First();
            if ( isset($_POST[$slugname]) )
              $do( $_POST[$slugname] );
          }
    }
