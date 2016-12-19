<?php
  class s_Settings {
    /*
      This is the class that changes the settings for the class
      and it's behaviour.
    */

    public function set_seperator($seperator)
      {
        $this->seperator = $seperator;
      }

    public function set_filter_array($filter_arr)
      {
        $this->filter_array = $filter_arr;
      }

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
  }
