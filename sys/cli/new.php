<?php
  function optline($msg)
    { echo "| $msg \n"; }
  function seperator()
    { optline( "-----------------------------------" ); }
  function string_contains($string, $contains)
    { if (strpos($string, $contains) !== false) return true; else return false; }

  $type = $argv[1];
  $name = $argv[2];

  //Manager for the type of input and want.
  if ($type == 'Kontroller')
    {
      if ( !string_contains($name, 'Kontroller') ) $name = $name . 'Kontroller';
      $path = dirname( __FILE__ ) . "\..\..\app\kontrollers\\$name.php";
      $add  =
        "<?php\n  class $name extends Kontroller {\n    public function index() {\n      //Lets do some interaction!\n\n      \$this->close_kontroller();\n    }\n  }";
    }
  else if ($type == 'Entry')
    {
      $path = dirname( __FILE__ ) . "\..\..\app\\entries\\$name.php";
      $add  =
        "<?php\n  echo 'This is the $name Entry generated from the CLI!';";
    }
  else
    {
      if ( !string_contains($name, 'Joint') ) $name = $name . 'Joint';
      $path = dirname( __FILE__ ) . "\..\..\app\joints\\$name.php";
      $add  =
        "<?php\n  class $name extends Joint {\n    public function ExampleFunction() {\n      //Lets do some database interaction hey!\n    }\n  }\n";
    }

    //File management.
    $f = fopen(  $path, "w" );
         fwrite( $f, $add );
         fclose( $f );
