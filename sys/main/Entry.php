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
    }
