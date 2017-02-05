<?php
  /*
  | We're trying to change the future.
  |   > The future of forms.
  |   > Shit... Sorry I thought this was techchrunch!
  |   > Just a form generator, nothing special.
  |
  | This is our backend OOP-based API.
  |
  | Any PSM calls should be made through
  | $api->psm->function_to_call()
  | Or if you're a pro lord 9000, use Globals::Get('psm')->function_to_call();
  | But that's ugly!
  */

  require_once "app/bare/API/BackendApiClass.php";
  $api = new API(
    Globals::Get('psm')
  );

  $api->POST([
    'index' => function($api) {
      $data = $api->s(['username', 'password']);
      $api->check('users->username', $data['username'], [
        'report' => 'Oops! That Username Exists!',
        'unique' => 'USERNAME_IN_USE'
      ]);
      $api->reload();
    },
    'auth_test' => function ($api) {
      $data = $api->s(['username', 'password']);
      $api->success('Woo!');
    }
  ]);
  $api->GET([
    'index' => function($api) {
      echo 'GET index';
    }
  ]);
