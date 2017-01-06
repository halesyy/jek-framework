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

    /*Returns the location of the config file wanted.*/
      public static function LoadConfig($configname)
        {
          return "sys/config/{$configname}.php";
        }

    /*This is the function to add reports to the Apps reporting system.*/
      public static function Log($msg, $color = 'green')
        {
          array_push( self::$logs, "<font color='{$color}'>".$msg."</font>" );
        }

    /*Inserts a line break into the logger.*/
      public static function LogBreak()
        {
          array_push( self::$logs, '<br/>' );
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
          self::TEMPCSS( '/public/css/jek-core/errors.css' );
          echo "<div class='jek-error-log'><div class='jek-error-top'>JEK Framework Error Log</div><div class='jek-error-title'><h1>{$title}</h1></div> <div class='jek-error-msg'>{$msg}</div> </div>";
          die();
        }
    /*Run for an Error. -- For 404 messages.*/
      public static function Error_404($title = '404', $message = 'Sorry, not found!')
        {
          self::TEMPCSS( '/public/css/jek-core/errors.css' );
          echo "<div class='jek-404-title'><h1>{$title}</h1></div><div class='jek-404-content'>{$message}</div>";
          die();
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

    /*Loads a temp CSS.*/
      public static function TEMPCSS($to)
        {
          echo "<link href='$to' type='text/css' rel='stylesheet' />";
        }
    /*Loads a temp JS.*/
      public static function TEMPJS($to)
        {
          echo "<script src='$to'></script>";
        }







    // Bootstap-related functions - For backend to frontend easy reporting.
      public static function Alert($message, $type = 'warning')
        {
          return '<div style="margin: 10px;" class="alert alert-'.$type.' alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.$message.'</div>';
        }








    //
  }
