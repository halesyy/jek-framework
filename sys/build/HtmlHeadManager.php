<?php
  /*
  |----------------------------------------------------------------------------------
  | HTML HEAD MANAGER
  |----------------------------------------------------------------------------------
  | This is the HEAD manager for your head file, so this will construct your head
  | depending on the slug given.
  |
  | In the Head_Management constructor, it creates a basic document start,
  | meaning the HEAD tag and HTML tag are already generated for you.
  |
  | LOADING PLUGINS
  | ---------------
  | To load plugins, you wanna call the "$head->Plugins" and "$head->LoadPlugins"
  | funcs, template:
  |   $head->Plugins( [  'plugin_name'   =>   [ 'js' => ['all-','js-','files'] ]   ] );
  | You may use as many as you want.
  |
  | NOTE
  | We use Require JS for our JavaScript loading, this framework is meant for SPAs
  | so you can find your Require JS config file at: "public/js/requirejs/config.js"
  | where you can manage your loads.
  | -- When calling the "LoadRequireJS" function, you're loading a file AFTER
  | -- config & requirejs was loaded correctly, a loader is just a file that manages
  | -- all your JS, so you can use the require function to load a file that does all
  | -- your jQuery! (example)
  |----------------------------------------------------------------------------------
  */
  /*
  | IDLE. - Initialize, Define, Load & End.
  */

    // Initialize.
    // Passed into array = slugs where <html>/<head> is generated.
    $head = new Head_Management(['index']);


    // Managing the first browser load to aid out SPA.
      $head->When('index', [
        'css' => [
          '/public/bootstrap/css/bootstrap.min.css',
          '/public/css/cssreset.css',
          '/public/css/main.css',
          '/public/css/jek-core/content.css',
          '/public/css/jek-core/forms.css',
          '/public/css/jek-core/header.css',
          '/public/css/jek-core/effects.css'
        ],
        'js'  => [
          'https://code.jquery.com/jquery-3.1.1.min.js',
          '/public/bootstrap/js/bootstrap.min.js',
          '/public/js/main.js'
        ],
        'google_font' => [
          'Lato|Montserrat|Oswald|Ubuntu|Ubuntu+Condensed|Open+Sans|Lora|Fira+Sans|Raleway'
        ]
      ]);

    //End.
    $head->End();
