<?php
  class Entry
    {
      /*
      | For loading Entries.
      */

      /*Loads the Entry the user wants.*/
        public function Load($filename, $data = [])
          {
            include "app/entries/{$filename}.php";
          }

      /*Loads an entry using the jHTML engine.*/
        public function LoadJHTML($filename, $data = [])
          {
            $j = new jHTML;
            $j->file( "app/entries/{$filename}.php" );
          }
      /*For testing the Entry class.*/
        public function Test()
          {
            echo "<b>Entry class Test called!</b>";
          }

      /*JTE = JEK TEMPLTAE ENGINE.
      Very simple engine so far to simply format variables a bit easier than calling
      the assoc array.*/
        public function JTE( $filename, $data = [] )
          {
            $location = "app/entries/{$filename}.php";
            if ( file_exists($location) )
              {
                $file_contents = file_get_contents( $location );
                foreach ( $data as $search => $replace )
                  $file_contents = str_replace( "{{{$search}}}", $replace, $file_contents );
                echo $file_contents;
              }
            else App::Error('Kontroller -> Entry -> JekTemplateEngine', "Tried to load file <b>{$location}</b> - NOT FOUND.");
          }
    }
