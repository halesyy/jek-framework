<?php
  class Globals
    {
      /*
      | Class meant to create easy-to-access globals accessible
      | through any scope of the framework.
      */
      protected static $vars = [];

      // Sets a variable to be used globally.
      public static function Set($name, $value)
        {
          $name = strtolower($name);
          self::$vars[ $name ] = $value;
        }

      // Gets a variable that's been set.
      public static function Get($name)
        {
          $name = strtolower($name);
          if (self::exists($name)) return self::$vars[ $name ];
          else App::Error('Globals class called', "<b>{$name}</b> variable not set - make sure it was!");
        }


      // Checks if a variable exists.
      public static function Exists($name)
        {
          if (isset( self::$vars[$name] )) return true;
          else return false;
        }
      public static function Exist($name) { return self::exists($name); }

      // Sets multiple globals.
      public static function Multiple($array)
        {
          foreach ($array as $name => $value)
          self::Set( $name, $value );
        }

      // Get all of the variables to use in an array if needed.
      public static function Vars()
        {
          return (object) self::$vars;
        }
    }
