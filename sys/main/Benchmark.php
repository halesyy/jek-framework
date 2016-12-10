<?php
  class Benchmark {
    /*
      Class for benchmarking script runtimes,
        WHEN CALL "Runtime",
        Runtime = Runtime from Router.php calls your file.

      Runtime is never ended normal, ender when user calls Runtime func.
    */

    //********************************************************************

      protected static $start = false;

      protected static $end   = false;

    //********************************************************************

    /*CALLED For start Runtime check.*/
      public static function RuntimeStart()
        {
          self::$start = microtime(true);
        }

    /*CALLED For check Runtime.*/
      public static function Runtime()
        {
          $start   = self::$start;
          $end     = microtime(true);
          $runtime = number_format( (float)($end - $start), 2, '.', '' );
          //Opt the runtime.
          echo "<div class='jek-report'><b>JEK</b>: Script finished execution in <b>{$runtime}</b> seconds</div>";
        }
  }
