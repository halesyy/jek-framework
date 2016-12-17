<?php
  class App {
    /*
      For the main application needs, such as loading modules & kontrollers.
    */

    //*****************************************************************

      protected static $logs  = [];
      protected static $run   = false;

    //*****************************************************************

    /*All initialization goes on here.*/
      public function Init(callable $do)
        {
          $successful = true;
            /*
              Code that's meant to be ran in init.
              Your code should check return types, etc... If false then set $successful = false.
            */

          $do($successful);
        }

    /*This is the function to add reports to the Apps reporting system.*/
      public static function Log($msg, $color = 'green')
        {
          array_push( self::$logs, "<b><font color='{$color}'>".$msg."</font></b>" );
        }

    /*Loads the report made by the Application.*/
      public static function LoadLog($force = false)
        {
          if ($force) echo "<pre>",print_r( self::$logs ),"</pre>";
            else self::$run = true;
        } public static function Logs() { self::LoadLog($force = false); }



    /*Run for an Error. -- For JEK.*/
      public static function Error($title, $msg)
        {
          echo "<div class='jek-error-log'> <div class='jek-error-title'>{$title}</div> <div class='jek-error-msg'>{$msg}</div> </div>";
        }



    /*For loading bare files from the bare folder.*/
      public static function Bare($filename)
        {
          require "app/bare/{$filename}";
        }



    /*Loads the logs after script execution if user requests.*/
      public static function FinalLogLoader()
        {
          if ( self::$run  )
            echo "<pre>" , print_r( self::$logs ) , "</pre>";
        }
  }
