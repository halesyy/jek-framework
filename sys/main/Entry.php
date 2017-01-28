<?php
  class Entry
    {
      /*
      | One of the TRI-FORCE classes to represent the JEK Framework.
      | TRI-FORCEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE!
      | Entry -> Kontroller <- Joint
      | Will render a new page for the browsers views.
      */

      //***********************************************************************************

        public $current_filename = false;

      //***********************************************************************************

      /*
      | @param String, Array, String
      | Loads a basic PHP file from the Entries file in the App folder.
      | Not too much to say about it, it extracts the data folder as variables
      | for the Entry.
      */
      public function Load($filename, $data = [], $type = 'php')
        {
          $this->current_filename = $filename.$type;
          App::Log("Going to load the Entry {$filename} with data, INTERNAL_PROTOCOL:NORMAL_LOAD", 'purple');
          $filename = "app/entries/{$filename}.{$type}";
          // Extracts the data variable.
            extract($data);
          // Premade vars that are useable in the Entry.
            $form = new Form;
          // Loading of the file.
          if ( file_exists($filename) ) include "{$filename}";
          else App::Error('Kontroller -> Entry -> Load', "Tried to load file <b>{$filename}</b> - NOT FOUND.");
        }



      /*
      | @param String, Array
      | Loads a file similar to the Load function but loads the file using
      | the jHTML templating engine - Supplied by the JEK Framework.
      */
      public function LoadJHTML($filename, $data = [])
        {
          App::Log("Going to load the Entry {$filename} with data, INTERNAL_PROTOCOL:JHTML_LOAD", 'purple');
          $j = new jHTML;
          $j->file( "app/entries/{$filename}.php" );
        }



      /*
      | @param String, Array, String
      | Jek Templating Engine.
      | Simple templating engine built for JEK (will have more functionality added later)
      | to convert the data array keys to variable names.
      | In this file, {{name}} is going to be replaced with $data['name'];
      | More functionality coming soon.
      */
      public function JTE($filename, $data = [], $type = 'php', $use_setter_and_templater = false)
        {
                App::Log("Going to load the Entry {$filename} with data, INTERNAL_PROTOCOL:JEKTEMPLATEENGINE", 'purple');
          $location = "app/entries/{$filename}.{$type}";
          if (file_exists( $location ))
            {
              $jte = new jTE;
              $jte->file($location, $data, $use_setter_and_templater);
            }
          else App::Error('Kontroller -> Entry -> JekTemplateEngine', "Tried to load file <b>{$location}</b> - NOT FOUND.");
      }
    public function Render($filename, $data = [], $type = 'php', $use_setter_and_templater = true)
      {
        $this->jte($filename, $data, $type, $use_setter_and_templater);
      }






    }

    /*
    | IN GLOBAL SCOPE SINCE IT NEEDS TO BE CALLED BY FORMS.
    | @param None
    | Will generate a hidden input in a form and set to a set token, then set
    | token in SESSION to be later retrieved from the API to authenticate.
    */
    function generate_csrf()
    {

    }
