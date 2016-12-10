<?php
  class jHTML_Interpreter extends jHTML_Templates {
    /*
      This is the class that manages the interpreting for the
      line-by-line or any other types of features added.

      This means this is where the templates are called to
      build the output then get outputted later on.
    */

    /*The main line-by-line management function.*/
      public function lbl_interpreter($line)
        {
          //remove mutlie line comments.
          // $line = preg_replace( '/\/\*(.*?)\*\//is', '', $line );
          if ($this->ce_using_comments($line))
            {}
          else {
            //grabs the TEMPLATE_CONTENT_EXT.
            $split = $this->t_c_e($line);
            $template = $split[0];
            $content  = $split[1];
            $ext      = $split[2];
            //calls to the template manager.
            $this->template_manage( $template, $content, $ext );
          }
        }

    /*Splits the ipt given into 3 pieces, the:
    Template: The template to be used for the rest of the content.
    Content.: The content in the template.
    Ext.....: Any extra information for the template.

    STACK TRACE/s: (I wrote two cause they're fun! ;D)
    |ipt|
        |remove-whitespace|
                          |explode-string|
                                         |get-template|
                                                      |try-find-ext|
                                                      |set-if-use-ext|
                                                                     |check-use-ext|
                                                                                   |true:false|
                                                    |get-content-using-preg-replace|          |get-content-by-looping|
                                  |return-data-array|                                                                |return-data-array|

    ipt -> remove-whitespace -> explode-string -> get-template -> try-find-ext -> set-if-use-ext -> check-use-ext -> true  -> get-content-using-preg-replace -> return-data-array
                                                                                                                  -> false -> get-content-by-looping -> return-data-array*/
      public function t_c_e($ipt, $remove_whitespace = true)
        {
          $line = $ipt;
          //removes whitespace.
          if ($remove_whitespace)
            $line = $this->remove_whitespace( $line );
          //explodes string by spaces.
          $pieces = explode( ' ', $line );
          //getting the template from the first explode.
          $template = $pieces[0];
          //sets ext, able to use that and check if its been used or not, ext=template content {ext}
          $old      = $line;
          $ext      = preg_replace(
            '/(.*?){(.*?)}/is',
            '$2',
            $line
          );
          $useext = ($old == $ext) ? false : true;
          //checks if the ext is used, if so get content using patterns that are able to match to ext.
          if ($useext)
            $content = preg_replace(
              '/(.*?) (.*?) {.*?}/is',
              '$2',
              $line
            );
          else {
          //if not, just get the content by looping and ignoring the first.
            foreach ($pieces as $index => $piece)
              if ($index == 0) {}
                else {
                  if (!isset($recon_arr)) $recon_arr = [];
                  array_push($recon_arr, $piece);
                }
            if (!isset($recon_arr) || count( $recon_arr ) == 0)
              $content = false;
            else
              $content = implode( ' ', $recon_arr);
          }
          if (!$useext) $ext = false;
          //returns the template, content and ext.
          return [$template, $content, $ext];
        }



    /*Checks to see if the user is currently using comments on the line.*/
      public $ml_comment = false;
      public function ce_using_comments($line)
        {
          $line = $this->remove_whitespace( $line );
          //management for whitespace line.
          if (strlen($line) < 2)
            return false;
          else {
            $possible_comment_bytes = $line[0].$line[1];
            $comments = ['::','//','##'];
            if ( in_array( $possible_comment_bytes, $comments ) )
              return true;
            else
              {
                if ($possible_comment_bytes == '/*')
                  $this->ml_comment = true;
                else if ($possible_comment_bytes == '*/')
                  {
                    $this->ml_comment = false;
                    return true;
                  }
                return $this->ml_comment;
              }
          }
        }
  }
