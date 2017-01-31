<?php
  class jTEBuilder extends jTERaindrops
    {
      /*
      | This is a class devoted to creating things in a nice and readable fashion.
      | Most of these are spins from other classes such as the Form class, where
      | you let out data and it's built and outputted.
      |
      | Builder is used by running code inbetween the builder, then parsed when
      | turning the builder off.
      */

      // *************************************************************

          public $storage = [];

          public $buffer = [];

      // *************************************************************

      public function __construct()
        {

        }




      /*
      | @param String
      | Takes in a string and stores it for parsing when the engine is told to.
      | Engine is meant to take in lines then parse later on.
      | Simply inputs a string and stores in it's own array of data.
      */
      public function store($line)
        {
          array_push($this->storage, $line);
        }

      /*
      | @param None
      | Will render from storage.
      */
      public function render()
        {
          foreach ($this->storage as $line)
            {
              // Will take each line stored and parse line into pieces
              // stores all data into the buffer.
              if (empty($line)) continue 1;
              $declarations = explode(':',$line);
              $this->buffer[ trim($declarations[0]) ] = trim($declarations[1]);
            }
          $this->caller();
        }

      /*
      | @param None
      | Will call the appropriate function from buffer inforamtion.
      | Buffer information is managed in the function Render.
      */
      public function caller($name = false)
        {
          if ($name === false) $name = $this->buffer['name'];
          if (count(explode('.',$name)) === 2)
            {
              // Going to call a function and give param of func wanted.
              $calls = explode('.',$name);
              if (method_exists($this, $calls[0]))
              $this->$calls[0]( $calls[1] );
              else App::Error('jTE Builder called', "Unknown method <b>\"{$calls[0]}\"</b>");
            }
          else
            {
              // Going to call function alone.
              if (method_exists($this, $name))
              $this->$name();
              else App::Error('jTE Builder called', "Unknown method <b>\"{$name}\"</b>");
            }
        }



      /*
      | @param Caller
      | The umbrella for all Form-related builds.
      */
      public function form($mname = 'generatejs')
        {
          $this->$mname( $this->buffer );
        }










      //
    }
