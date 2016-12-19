<?php
  class Set
    {
      /*
      | Set is a class built for easy changes in the DOM as well as easy page manip.
      |
      | Example:
      |   $this->c->set()->title = 'Jack!';
      |   > Changes the Title of the current page to 'Jack!'.
      */

      //*********************************************************************************

        private $title = false;

      //*********************************************************************************

      /*The actual set change manager.*/
      public function __set($name, $set)
        { //FUNCNAME = ChangeManager.
          if ( method_exists($this, $name) )
            $this->$name($set);
        }

      /*Changing the title of the page.*/
      private function title($title)
        {
          echo
            "<script>$(document).ready(function(){if ($('title').length)$('title').html('$title');else $('head').append('<title>$title</title>');});</script>";
        }
    }
