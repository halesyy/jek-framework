<?php
  /*
    File for initializing most of the components for JEK.
  */

    //Loading all functions/classes/scripts that are needed to be loaded first.
      foreach ( glob('sys/load_first/*.php') as $inc )
        include_once($inc);

    //Loading the "build/config.php" file, which loads & manages the config.
      require_once( "build/config.php" );

    //Loading all main classes in system.
      foreach ( glob('sys/main/*.php') as $inc )
        include_once($inc);

    //Starting up App class.
      $app = new App;
      $app->Init(function($r){
        if ($r) App::Log('Initialization was correctly loaded', 'green');
           else App::Error('Init load', 'Init load was unsuccessful');
      });

    //Loading all our libraries we want.
      #Include all classes in this (v) file.
      include_once "app/libs/Init.php";
      App::Log('Loaded LIBRARIES', 'blue');

    //Loading the routes to determine the corr. Kontroller.
      $cur = Url::First();
      include_once "sys/build/Routing.php";
      App::Log("Finished router exec, get = {$cur}", 'orange');

    //Log the finish of this file.
      App::Log('Finished loading init.php', 'red');

    //Management for a set of user wants to load the log.
