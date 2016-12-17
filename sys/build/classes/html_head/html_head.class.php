<?php

  class Head_Management
  {
    /*
    | Class meant to add functionality for managing the input of slugs with corrolation to
    | the HTML head.
    */

    //************************************************************************************

      protected $schemes = [
        'css'        => "<link rel='stylesheet' type='text/css' href='IMPORT' />",
        'js'         => "<script src='IMPORT'></script>",
        'javascript' => "<script src='IMPORT'></script>",
        'asyncjs'    => "<script src='IMPORT' async></script>",
        'title'      => "<title>IMPORT</title>"
      ];

      protected $plugins = [
        /*
        | Plugin name => Plugin contents array.
        */
      ];

      protected $plugin_names = [
        /*
        | Just contains Plugin names -- A numeric array.
        */
      ];

      /*Path to the Require.js file.*/
      protected $to_requirejs = '/public/js/requirejs/require.js';
      /*Path to the Require.js config file.*/
      protected $to_requirejs_config = '/public/js/requirejs/config.js';
      /*Array containing the index slugs to load the head starter and ender on.*/
      protected $load_html_start     = [];

    //************************************************************************************

    /*Constructor.*/
      public function __construct($load_html_start)
        {
          $this->load_html_start = $load_html_start;
          if ( in_array( Url::First(), $load_html_start ) )
            echo "<html>\n  <head>\n";
        }
  /*If first param = first slug will run.*/
    public function When($slug, $contents)
      {
        if ($slug == Url::First() || $slug == 'always')
          foreach ($contents as $import_type => $import_contents)
            $this->Import( $import_type, $import_contents );
      }

  /*Does importing depending on the scheme type.
  SCHEME=e.g.:CSS/JS/TEMPLATE_ACCESS
  TO_IMPORt=e.g.HREF/CSS_FILE/JS_FILE*/
    public function Import($scheme, $to_import)
      {
        $template = $this->schemes[$scheme];

        foreach ($to_import as $import)
        {
          echo "    <!--{$scheme}-->\n";
          echo "    ".str_replace( 'IMPORT', $import, $template )."\n";
        }
      }



  /*Loading the plugins into the class variables.*/
    public function Plugins($plugin_container)
      {
        $this->plugins = $plugin_container;
        //Loads the plugin names into numeric array.
        foreach ( $plugin_container as $plugin_name => $plugin_contents )
          array_push( $this->plugin_names, $plugin_name );
      }

  /*Loading the plugins if set to true from plugin name.*/
    public function LoadPlugins($load_array)
      {
        foreach ($load_array as $plugin_name => $use)
          if ($use) {
            //Checks if Plugin exists.
            if ( !isset($this->plugins[$plugin_name]) ) die("plugin <b>{$plugin_name}</b> not existant");
            $plugin_contents = $this->plugins[$plugin_name];
            //Loading the content from the Plugin content. (Given from the Plugins function)
            foreach ($plugin_contents as $scheme => $import_content )
              $this->Import($scheme, $import_content);
          }
      }
  /*Lets user load all plugins despite want.*/
    public function LoadAllPlugins()
      {
        foreach ($this->plugins as $plugin_name => $plugin_contents)
          foreach ($plugin_contents as $scheme => $import_contents)
            $this->Import($scheme, $import_contents);
      }
  /*Runs both the Plugins function as well as the plugin management function.*/
  public function PluginManagement($man_arr)
    {
      $this->Plugins( $man_arr[0] );
      $this->LoadPlugins( $man_arr[1] );
    }

  /*Signals the end of the Head.*/
    public function End()
      {
        if ( in_array( Url::First(), $this->load_html_start ) )
          echo "  </head>\n  <body>\n    ";
      }


  /*For loading in Require JS and a loader file.*/
    public function LoadRequireJS($loader = '/public/js/requirejs/loader.js')
      {
        echo
        "    "
        ."<script src='{$this->to_requirejs}' data-main='{$this->to_requirejs_config}'></script>\n"
        ."<script>require(['loader', function(){}])</script>";
      }

  }
