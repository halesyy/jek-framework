<?php
  class jHTML_Components {
    /*
      This is the class that's meant for the extra functions
      that help the processing of jHTML's engine, such as
      development tools, functions to sanitize inputs, etc...
    */

    /*Takes in an input and makes sure it is one
    of the specific_array elements.*/
      public function san_input($input, $specific_array)
        {
          if (!in_array($input, $specific_array))
            return false;
          else
            return true;
        }
    /*Takes in the function name from const __FUNCTION__ and opts
    an error with the description.*/
      public function error($functionname, $desc)
        {
          echo "<h2 style='padding:0;margin:0;'>jHTML compile error</h2>"
          ."<h3>@function $functionname</h3>"
          ."<p>$desc</p>";
          die();
        }
    /*Opts an array using formatting. - Can handle multiple ipts.*/
      public function display()
        {
          foreach (func_get_args() as $arr) {
            if (is_array($arr))
              {
                //management for "invisible" ipts such as true/false.
                foreach ($arr as $index => $items)
                if ($arr[$index] === false) $arr[$index] = 'false';
                else if ($arr[$index] === true) $arr[$index] = 'true';
                //opts the array.
                echo "<pre>",print_r($arr),"</pre>";
              } else {
                echo "<b>$arr</b>";
              }
          }
        }
    /*Removes whitespace from line.*/
      public function remove_whitespace($ipt)
        {
          $ipt = preg_replace('/\s+/', ' ', $ipt);
          $ipt = ltrim($ipt, ' ');
          return $ipt;
        }


      /*Returns a text-highlighted version of the text.*/
        public function return_text_highlighted($ipt)
          {
            foreach ( explode("\n",$ipt) as $line )
              {
                $pieces = $this->t_c_e($line, false);
                if ($pieces[1] == $line) $pieces[1] = '';

                echo "<div>
                  <font color='red'>{$pieces[0]}</font>
                  <font color='green'>{$pieces[1]}</font>
                  <font color='blue'>{$pieces[2]}</font>
                </div>";
              }
          }


  }
