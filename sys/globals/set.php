<?php
  /*
  | This file uses the class Globals to create easy-to-access
  | global variables through any scope of the entire framework.
  |
  | To set a new variable, simply add a new entry to the array
  | and set the key = variable name, and value = variable data.
  |
  | To call the data you set later on, use Globals::Get('variable name');
  | which will return the variable's data.
  */

    Globals::Multiple([
      'version' => '2.0',
      'ip'      => $_SERVER['REMOTE_ADDR'],
      'time'    => time()
    ]);
