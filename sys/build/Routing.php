<?php
  Benchmark::RuntimeStart();
  /*
  |----------------------------------------------------------------------------------
  | ROUTING
  |----------------------------------------------------------------------------------
  | Routing File:
  | This class is meant to re-model browser requests to your code, making it
  | easier to manage calls.
  |
  | We supply you with the "$router" variable, you'll be using that to route
  | all your requests.
  |
  | If you want a Kontroller to be called at the specific URI request, just do:
  |   $router->On('Index', 'Index');
  | And that will call the Index_Kontroller.
  | (If you ignore the second variable, it'll set it to the second, so Index
  | points to the Index_Kontroller class.)
  |
  | If you want a callback to be defined, just do:
  |   $router->Get('Index', function($kontroller){
  |     $kontroller->Load('LoadThisKontroller');
  |     App::Log('Loaded LOADTHISKONTROLLER successfully', 'orange');
  |   });
  | But that's for small bits of code, don't put all your code in here!
  |
  | NOTE
  |  Cause for some reason me (the developer) even had this, don't (in a callback) do:
  |    $k->kontroller->load('Kontroller')
  |  As that means you'e loading a bare, plain object, meaning you can't load
  |  joins or entries from the "$this" object.
  |
  | Also:
  |   When there's no information in the URI, 'index' is called, e.g.:
  |   if URL = 'localhost/', then the current slug is 'index', but if the
  |   URL = 'localhost/something', then the current slug is 'something'!
  |----------------------------------------------------------------------------------
  */

    $router = new Router;

    // Will look at the first two inputs and decide if safe or not.
    $router->SanitizeUrl([ 0 => true,
      // A special charset in the Router Class (you can edit it)
      // that contains all letters ALLOWED in the ENTIRE URL, not specific URLs.
      'force-characterset' => true,

      // Managing the first and second segments of the URL.
      'first' => [
        'force-type' => ['LETTERS']
      ],
      'second' => [
        'force-type' => ['LETTERS', 'NUMBERS', 'SPECIALS']
      ]
    ]);
    $router->Api();

    $router->RouteMultipleInstances([
      'index' => [
        'call'    => 'main/IndexKontroller@index',
        'when'    => 'get',
        'dynamic' => true
      ],
      'home' => [
        'call'    => 'main/IndexKontroller@home',
        'when'    => 'get',
        'dynamic' => true
      ]
    ]);
    //
