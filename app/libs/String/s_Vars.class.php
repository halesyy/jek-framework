<?php
  class s_Vars extends s_Management {
    /*
      Class for containing all of the vars for the String class.
    */

    //Public Working String.
    public $pws = false;
    //Filter Array used when there's no paramater for filter.
    public $filter_array = false;
    //For if the filter fails, make sure that there's no opt!
    public $filter_fail = false;
    //The last type that was used and would be opt'd.
    public $last_type = false;
    //The current result resolved from the vars.
    public $result = null;
    //The current result if array.
    public $result_a = [];

    //Settings vars.
    public $seperator = ',';
  }
