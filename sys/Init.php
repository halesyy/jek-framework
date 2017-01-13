<?php
  /*
  | ********************************************* |
  | CONTENTS                                      |
  | ********************************************* |
  |                                               |
  |    0.  Your App And You (Joke)                |
  |                                               |
  |    1.  Illegal URL Manager                    |
  |                                               |
  |    2.  Load First Methods/Classes             |
  |                                               |
  |    3.  Set Globals                            |
  |                                               |
  |    4.  Build/Mange Config                     |
  |                                               |
  |    5.  Load Main Classes                      |
  |                                               |
  |    6.  Build/Manage Libraries                 |
  |                                               |
  |    7.  Route Application                      |
  |                                               |
  |    8.  End                                    |
  |                                               |
  | ********************************************* |
  */

  // ************************************************************



  // ************************************************************

  /*
  | First part of the framework.
  | --
  | File will do the first firewall for illegal URI's, and will output
  | a message for illegal URI accessors, to add a new illegal URI request,
  | simply add a new entry to the array containing the URI you want to
  | blacklist, the entry of the array is for the URI after the /,
  | so "localhost/"BLACKLIST.
  | If the URL is "localhost/one/two/three" - The exact URI is
  | /one/two/three, so just set the one/two/three as the blacklist
  | and that'll blacklist anyone from accessing "localhost/one/two/three"
  */

    require_once "sys/config/urikillers.php";

  /*
  | This is if you're using XDEBUG, I use this a lot in development
  | so I have this line used a lot.
  */
    // if (false)
    // $_GET['XDEBUG_PROFILE'] = true;


  /*
  | Loading all of the functions marked as "load first," these are
  | the "core" of the entire framework, and most other classes
  | are dependant on these classes being built, such as the
  | App manager and URL manager (to pull data from the URL),
  | so these are must-haves for the Application to run,
  | even before classes such as the overall Kontroller class,
  | you'll see more BASE-PHP-Functions in these classes as they're
  | the first-loaded methods/classes, and aren't meant to rely on
  | other classes or Alphabetical loads (BClass.php can rely
  | AClass.php since it's going to be loaded first (Alphabetical)).
  |
  | Example: You'll see lots of "App::Log"'s, since that handles users
  | being able to un derstand the load path, etc..., use App::Logs() to
  | load logs after the App is ran.
  |
  | Add new log: The prefered technique for logging is to have the actual
  | log occur 3/4 tabs from the normal tab scope.
  */
    $_GET['XDEBUG_PROFILE'] = true;

    foreach ( glob( 'sys/load_first/*.php' ) as $inc )
    include_once($inc);
          App::Log('Finished loading all scripts labeled as \'load first\'', 'green');




  /*
  | Loads the global setter, this is a class loaded from the "load first"'s,
  | and takes advantage of PHP's global static classes, letting them be
  | accessable from any scope, so instead of using the $_GLOBALS variable,
  | the Framework uses this class to store global variables.
  |
  | You can set new globals by looking in this file and adding a new assoc
  | array entry, the key is the variable name and the value is the variable's
  | value, you can later access these by using the Globals::Get('Variable Name').
  |
  | As well as that, there's many places in the framework that create new
  | Globals variables, such as database creation will make Globals::Get('psm')
  | existant.
  |
  | To set a Global later on in the scope, use Globals::Set('Variable Name'),
  | then use Get to later get the variables value.
  */
    require_once( "sys/globals/set.php" );
          App::Log('Finished setting all globals requested from <b>sys/globals/set.php</b>', 'darkblue');
          App::LogBreak();




  /*
  | This area loads the configuration builder, which will simply require
  | in configs from "/sys/config" containing variables to influence the
  | behaviour of the JEK Framework and all its components.
  |
  | Configs are used this way since we wanted to move away from the old
  | method where they were loaded using Alphabetical order then managed
  | inside of the file itself, instead the config files are meant for
  | setting, and the config builder is in charge of managing and requiring
  | in the files TO manage them.
  */
    require_once( "sys/build/config.php" );
          App::Log('Finished building the configuration and managing', 'green');




  /*
  | Loading in all main JEK classes, these classes are used for mamaging the
  | flow of components and easing application development.
  |
  | Some classes are: Kontroller, Entry, Joint, Router, Builder, Benchmark,
  | Toolset, Set, etc...
  |
  | You can call most of these classes inside of a premade Kontroller.
  | NOTE None of these classes actually influence creation of HTML outputting,
  | Document management, etc... That comes in after (HTMLHead manager will somemwhat
  | change the Document, since it generates the HEAD of the Document dynamically,
  | though rendered content such as the BODY comes after.)
  */
    foreach ( glob('sys/main/*.php') as $inc )
    include_once($inc);
          App::Log('Finished loading all \'main\' JEK Framework classes', 'green');




  /*
  | Loading in the libraries;
  | These aren't as important as the main classes, but still are needed in order for the
  | framework to run smoothly, such as Form managers, Authenticators, etc...
  | This is the manager file for them, since there can be a lot in one folder therefore
  | making folders to manage them is a must, therefore this loads the Libs file to
  | specify the files to load in, IN order.
  */
    include_once "app/libs/Init.php";
          App::Log('Finished loading Libraries from folder <b>app/libs/Init.php</b>', 'blue');




  /*
  | NOTE This is where the specific content is rendered.
  | Loading the Frameworks Router, which is the finish of initialization and the start
  | of routing the application to the correct files and classes and calling the correct
  | methods.
  | The Router is incharge of looking at the URI, filtering the URI, sorting the
  | config out and understanding what classes to call, knowing if it's a dynamic call
  | to the Kontroller or not, etc...
  |
  | To add new URI configurations, this is the file to do so!
  */
    include_once "sys/build/Routing.php";
          App::Log("Finished Router execution, ran where first index = ".Url::First(), 'orange');
          App::LogBreak();




  /*
  | After initialization, will log the finish of the Application being ran and end file.
  */
          App::Log('Finished application initialization, <b>no errors encountered</b>', 'red');
          App::FinalLogLoader();










  /**/
