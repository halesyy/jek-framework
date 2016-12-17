<?php
  //Manager for the Router if you wanna use CLI to do it quicker.

    if ($argv[1] == 'new')
      {
        $slug       = $argv[2];
        $kontroller = $argv[3];

        $to_add =
            "\n    \$router->Get('$slug',  function(\$kontroller){\n      \$kontroller->Load('$kontroller');\n    });";
        $router_loc = dirname( __FILE__ ) . "\..\build\\Routing.php";
        $f          = file_put_contents( $router_loc, $to_add, FILE_APPEND | LOCK_EX );

        echo "\n\nThanks for letting dad deal with them. You're safe now.\n\n";
      }
