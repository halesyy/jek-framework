<?php
  class String extends s_Vars {
    /*
      This is the class for helping with easy-to-read string manipulation.
      Class can aid in manip so you can easily do any string manip and selection, such as:
        -Character selection
        -Return types
        -Filtering

      Some examples are:

        Filter the string to only contain items given in an array.
        $string->s("Hello World!")->filter(['Hello World!', 'String!'])->opt()
        Stack trace:
          Selects the string "Hello World!"
          Filters the string to fit: "Hello World!" OR "String!"
          Outputs the answer to the call.
        This would output "true," cause indeed the string conforms to the filter.
    */



    public function __construct($ipt = false)
      {
        $this->pws = $ipt;
      }


    public function __invoke($ipt)
      {
        $this->pws = $ipt;
        return $this;
      }


  }
