<?php
  /*Small class for setting globals.*/
    class GLOBALS
    {
      protected static $vars = [];

      public static function SET($NAME, $VAL)
        {
          self::$vars[$NAME] = $VAL;
          return $VAL;
        }

      public static function GET($NAME)
        {
          return self::$vars[$NAME];
        }

      public static function EXIST($NAME)
        {
          if (isset(self::$vars[$NAME]))
            return true;
          else
            return false;
        }

      public static function MULTIPLE($ARR = [])
        {
          foreach ($ARR as $NAME => $VAL)
            {
              self::$vars[$NAME] = $VAL;
            }
        }
    }
