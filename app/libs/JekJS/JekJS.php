<?php
  class jekjs
    {
      /*
      | Simple php->js function caller to parse functions
      | and build client-side JS to be outputted. Runs jQuery on top of everything.
      */

      //*********************************************************************

      //*********************************************************************

      public function __construct($start_tag = true)
        {
          if ($start_tag) echo "\n".'<script type="text/javascript">'."\n";
        }

      public function __invoke()
        {
          echo '$(document).ready(function(){';
          return $this;
        }
      public function escript($end_tag = true)
        {
          echo "\n".'});';
          if ($end_tag) echo "\n".'</script>';
          return $this;
        }



      /*
      | @param String, Array
      | Will parse the inputs and output a function for JS to render later on.
      */
      public function func($fname, $params = [])
        {
          echo "\n{$fname}(";
          foreach ($params as $index => $pdata) $params[$index] = '\''.$pdata.'\'';
          echo implode(',',$params);
          echo ');';

          return $this;
        }
    }
