<?php
  /*
    File for initializing most of the components for JEK.
  */

    //Loading all functions/classes/scripts that are needed to be loaded first.
      foreach ( glob( 'sys/load_first/*.php' ) as $inc )
      include_once($inc);
            App::Log('Finished loading all scripts labeled as \'load first\'', 'green');

    /*
    | Loading the sys/globals/set.php file - meant to set globals the user
    | wants to use.
    */
      require_once( "sys/globals/set.php" );
            App::Log('Finished setting all globals requested from <b>sys/globals/set.php</b>', 'darkblue');
            App::LogBreak();


    /*
    | Loading the config builder from sys/build/config.php,
    | which will manage all config files located in sys/config.
    */
      require_once( "sys/build/config.php" );
            App::Log('Finished building the configuration and managing', 'green');

    //Loading all main classes in system.
      foreach ( glob('sys/main/*.php') as $inc )
        include_once($inc);
            App::Log('Finished loading all \'main\' JEK Framework classes', 'green');

    //Loading all our libraries we want.
      #Include all classes in this (v) file.
      include_once "app/libs/Init.php";
            App::Log('Finished loading Libraries from folder <b>app/libs/Init.php</b>', 'blue');

    //Loading the routes to determine the corr. Kontroller.
      $cur = Url::First();
      include_once "sys/build/Routing.php";
            App::Log("Finished Router execution, ran where first index = {$cur}", 'orange');
            App::LogBreak();

    //Log the finish of this file.
            App::Log('Finished application initialization, <b>no errors encountered</b>', 'red');

    //Management for a set of user wants to load the log.
      App::FinalLogLoader();
