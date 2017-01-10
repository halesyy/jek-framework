<?php
  /*
  | Will check if URI is in the the array, if so output something and kill script.
  | KILL THE URLS!
  | This is the step-up to securing URLs, so you can kill them before any script is ran.
  */

  $blacklist = [
    'favicon.ico'
  ];

  foreach ($blacklist as $index => $bl) $blacklist[$index] = '/'.$bl;
  if ( in_array( $_SERVER['REQUEST_URI'], $blacklist ) ) exit("Illegal URL");
