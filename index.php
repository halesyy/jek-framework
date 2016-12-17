<?php
  ob_start();
  session_start();
  /*
       ___  _____  _   __
      |_  ||  ___|| | / /
        | || |__  | |/ /
        | ||  __| |    \
    /\__/ /| |___ | |\  \
    \____/ \____/ \_| \_/
    ______                                                       _
    |  ___|                                                     | |
    | |_    _ __   __ _  _ __ ___    ___ __      __  ___   _ __ | | __
    |  _|  | '__| / _` || '_ ` _ \  / _ \\ \ /\ / / / _ \ | '__|| |/ /
    | |    | |   | (_| || | | | | ||  __/ \ V  V / | (_) || |   |   <
    \_|    |_|    \__,_||_| |_| |_| \___|  \_/\_/   \___/ |_|   |_|\_\

       - The hackiest framework ever! (Amen to quick development <3)

       ::::==========:::::::::::::::::::::::::::::::::::::::::::::::::::::::
        :::::::=========::::::.---------------.:::::::::::::::::::::::::::::::
        :::=============::::::| .-----------. |:::::::::::::::::::::::::::::
        ::::==========::::::::| | === == == | |:::::::::::::::::::::::::::::::::
        ::::==========::::::::| | 260 ED OO | |:::::::::::::::::::::::::::::::
        :::::::=========='::::| |  urgent!  | |:::::::::::::::::::::::::::::
        :::===========::::::::| |___________| |::::::((;):::::::::::::::::::::
        """"============""""""|___________oo__|"")"""";(""""""""""""""""""""""
          ==========='           ___)___(___,o  (   .---._
             ===========        |___________| 8  \  |COF|_)    .+-------+.
          ===========                     o8o8    ) |___|    .' |_______| `.
            =============      __________8___    (          /  /         \  \
         |\`==========='/|   .'= --------- --`.   `.       |\ /           \ /|
         | "-----------" |  / ooooooooooooo  oo\   _\_     | "-------------" |
         |______I_N______| /  oooooooooooo[] ooo\  |=|     |_______JEK_______|
                          / O O =========  O OO  \ "-"   .-------,
                          `""""""""""""""""""""""'      /~~~~~~~/
        _______________________________________________/_   ~~~/_______________
        ............................................. \/_____/..desk at 17:30..

        Work on this Framework like you're in an office.
  */


  //************************************************************************************


  /*
  | ------------------------------------------------------------------------------------
  | QUICK RUN THROUGH ON CONSEPTS OF THIS FRAMEWORK.
  | ------------------------------------------------------------------------------------
  | A normal (most) framework runs off MVC (Model -> View -> Controller), which is the
  | core of this framework, but the names have been re-written, so:
  | MVC = JEK
  |   Model:       Joint,
  |   View:        Entry,
  |   Controller:  Kontroller
  |
  | When a browser connects to the framework, we run a Routing system,
  | so if the browser calls "localhost/name/jack", in your "sys/build/Routing.php"
  | file, you can specify what Kontroller that calls.
  | NOTE Read more in the file itself for more information on how to Route.
  |
  | In a Kontroller, the main function is to process data, such as call a Joint class
  | to get some data from a Database, which you can specify Database connection vals from
  | "sys/config/database.php".
  |
  | After processing your data, you can call an Entry to display your data on-browser.
  | ------------------------------------------------------------------------------------
  */

  //************************************************************************************


  require_once "sys/Init.php";



  ob_flush();
  //
