<?php
  class jHTML_Compile extends jHTML_Interpreter {
    /*
      This is the class meant to do the comiling,
      TOP_LEVEL_COMPILING

      That means there's compiling going on for the top level,
      meaning, this is where you send your un-formatted data
      and have it processed by sub-functions.
    */

    /*Takes in an input and depending on type will process.
    lbl  = 'line-by-line' - parsed line by line input string.
    file = 'file' - parsed line by line file. */
      public function compile($input, $type = 'lbl')
        {
          //management for line-by-line inputs.
          if ($type == 'lbl')
            foreach ( explode("\n", $input) as $line )
              $this->lbl_interpreter( $line );
          else if ($type == 'file')
            {
              $file = fopen( $input, "r" );
              $lns  = fread( $file, filesize($input) );
              foreach ( explode("\n", $lns) as $line )
                $this->lbl_interpreter( $line );
              fclose($file);
            }
        }

      /*Shorthand function for compile.*/
        public function c($input, $type = 'lbl')
          {
            $this->compile($input, $type);
          }

      /*Shorthand function for compiling a file.*/
        public function file($input)
          {
            $this->compile($input, 'file');
          }

      /*Shorthand function for compiling a file.*/
        public function text($input)
          {
            $this->compile($input, 'lbl');
          }


  }
