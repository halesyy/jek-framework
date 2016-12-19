<?php
  $path = dirname( __FILE__ ) . "\..\..\sys\config\display.php";
  require "$path";

  $all = [];

  //putting in links.
  foreach ( $cfg['header']['header-links'] as $container )
    {
      $to = $container[1];
      array_push($all, $to);
    }

  foreach ( $cfg['header']['header-links-right'] as $container )
    {
      $to = $container[1];
      array_push($all, $to);
    }

  foreach ( $cfg['header']['header-dropdowns'] as $container )
    {
      foreach ( $container[1] as $name => $to )
        {
          $k     = explode( '/', $to );
          $newto = $k[0];
          array_push( $all, $newto );
        }
    }

    $all = array_keys( array_count_values($all) );

    echo "\n--\nYou need to create: \n--\n\n";
    print_r($all);
