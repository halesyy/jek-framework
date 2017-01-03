<?php
  /*
  | This is our backend OOP-based API.
  |
  | Any PSM calls should be made through
  | $api->psm->function_to_call()
  */

  require_once "app/bare/API/BackendApiClass.php";
  $api = new API(GLOBALS::GET('psm'));

  $api->POST([
    'index' => function($api) {
      $data = $api->s(['username', 'password']);
      $api->check_table('users', [
        'for'    => 'asd',
        'in'     => 'username',
        'report' => 'Oops! That Username Exists!',
        'unique' => 'USERNAME_IN_USE'
      ]);

      $api->success('Woo! Done!');
    }
  ]);

  $api->GET([
    'index' => function($api) {
      echo 'GET index';
    }
  ]);
