<?php
  class Toolset {
    /*
      This is the class containing some PHP tools to make it easier, includes debugging tools,
      etc...
    */

    /*Opts an array using formatting. - Can handle multiple ipts.*/
      public function display()
        {
          foreach (func_get_args() as $arr) {
            if (is_array($arr) || is_object($arr))
              {
                //management for "invisible" ipts such as true/false.
                foreach ($arr as $index => $items)
                // if ($arr[$index] === false) $arr[$index] = 'false';
                // else if ($arr[$index] === true) $arr[$index] = 'true';
                //opts the array.
                echo "<pre>",print_r($arr),"</pre>";
              } else {
                echo "<b>$arr</b>";
              }
          }
        }

  }
