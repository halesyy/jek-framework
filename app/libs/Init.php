<?php
  /*
    This is the file with the given task of loading all classes in the
      ordr_funcs (Ordered Classes)
    Meaning, they need to be loaded in a special order.
  */

  /*TO SELF PARENT FOLDER.*/
  $to = "app/libs";

  include_once "{$to}/jHTML/jHTML_Components.class.php";
  include_once "{$to}/jHTML/jHTML_Templates.class.php";
  include_once "{$to}/jHTML/jHTML_Interpreter.class.php";
  include_once "{$to}/jHTML/jHTML_Compile.class.php";
  include_once "{$to}/jHTML/jHTML.class.php";
