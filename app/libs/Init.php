<?php
  /*
    This is the file with the given task of loading all classes in the
      ordr_funcs (Ordered Classes)
    Meaning, they need to be loaded in a special order.
  */

  /*TO SELF PARENT FOLDER.*/
  $to = "app/libs";


  //jHTML.
  include_once "{$to}/jHTML/jHTML_Components.class.php";
  include_once "{$to}/jHTML/jHTML_Templates.class.php";
  include_once "{$to}/jHTML/jHTML_Interpreter.class.php";
  include_once "{$to}/jHTML/jHTML_Compile.class.php";
  include_once "{$to}/jHTML/jHTML.class.php";

  //String m. class.
  include_once "{$to}/String/s_Settings.class.php";
  include_once "{$to}/String/s_Management.class.php";
  include_once "{$to}/String/s_Vars.class.php";
  include_once "{$to}/String/String.class.php";

  //SuperCrypt class.
  include_once "{$to}/SPRCRPT/SuperCrypt.php";

  //jekjs Class.
  include_once "{$to}/JekJS/JekJS.php";

  //jTE Templating Class.
  include_once "{$to}/jTE/jTE.php";
  include_once "{$to}/jTE/jTERaindrops.php";
  include_once "{$to}/jTE/jTEBuilder.php";

  //Form class.
  include_once "{$to}/Form/Form.php";
