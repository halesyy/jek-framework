<?php
  class jTE
    {
      /*
      | The jekTemplateEngine class, meant to compile files
      | to make code look nice and squeaky clean - And easy to read.
      |
      | Inspiration taken from the Blade Templating Engine, understand
      | this is a project I'm using to create apps, and not the
      | entire world will be using it, so I can say stuff like that.
      */

      // ***************************************************************

        /*
        | @vars Bool, Bool.
        | All vars related to if-statements and their clauses
        | as well as execution-changes.
        */
        public $in_if_mode      = false;
        public $execute_if_code = false;


        /*
        | @var Array | Contains Classes
        | Contains the classes that are triggereable by the LBL
        | interpreter.
        */
        public $classes = [];

        /*
        | @var Array
        | Contains the current rendereing pages data array,
        | containinig varnames and vardata as such.
        */
        public $data = [];

        /*
        | @var Bool
        | This is the boolean variable to declare whether the
        | framework page being rendered is in "SETTING" mode
        | or not, from default it's on FALSE, therefore to
        | trigger this mode you have to use the @setter
        | on a single line to initialize setter = true,
        | then call again to set setter = false.
        */
        public $in_setter_mode = false;

        /*
        | @var Bool
        | Deters if the class is in builder mode or not.
        */
        public $in_builder_mode = false;

        /*
        | @var Array
        | These are the "@import X" keywords, they're meant to
        | point to a specific filename IN the entry folder,
        | so if you say "header => Header.php", will import
        | /app/entries/Header.php, so don't do the true path!
        |
        | After the keywords are checked, will assume keyword
        | is a true path and attempt to load that in, if both
        | don't work, will simply output a core error message.
        */
        public $import_keywords = [
          'header' => 'main/static/Header.php',
          'footer' => 'main/static/Footer.php'
        ];

        /*
        | @var Bool
        | If this is set to TRUE, when building files using
        | the jTE engine, will parse in-built PHP before actually
        | parsing and using the engine.
        | If set to FALSE, will read the file as its raw contents.
        */
        public $parse_inline_php = true;

        /*
        | Stores the Builder class.
        */
        public $builder = false;

      // ***************************************************************

      /*
      | @param None
      | Meant to set the classes triggerable by the LBL interpreter.
      */
      public function __construct()
        {
          $this->classes = [
            'Form' => load_class('Form'),
            'JTE'  => $this
          ];
          $this->shorthand_setter_vars = [
            'session' => &$_SESSION,
            's'       => &$_SESSION
          ];
          $this->builder = new jTEBuilder;
        }













      /*
      | @param String, Array
      | This method will take in a filename and load the content
      | using an output buffer to render the PHP, then gather the
      | content and use the jTE rendering engine to render all other
      | content such as variables, etc...
      */
      public function file($filename, $data = [])
        {
          $this->data = $data;

          if (file_exists( $filename ))
            {
              // Setting of variables that are going to be used for PHP itself.
                $form = new Form;
              // Gathering page data by parsing the PHP file.
                if ($this->parse_inline_php)
                  {
                    ob_start();
                    include_once "{$filename}";
                    $content = ob_get_clean();
                  } else $content = file_get_contents($filename);
              // Adding the content from the Setter first.
                $setter = (file_exists( "app/entries/Setter.php" )) ? file_get_contents("app/entries/Setter.php") : '';
                $content = $setter.$content;
              // Runs the Interpreter.
                $this->interpreter($content);
            }
          else App::Error('jTE File Compile Called', "<b>{$filename}</b> not exist");
        }




      /*
      | @param String, Array
      | Given content to parse, usually from the file() method.
      | Method manages the content by calling other methods to to
      | parse and manage the data.
      | This is the SESSION (TCP MODEL REFERENCE) type Method
      | of the class.
      | ************************************************************
      | CALL CLASS -> GET CONTENT -> INTERPRETER TO MANAGE DATA.
      */
      public function interpreter($content)
        {
          // Will call appropriate methods to get new data sets back
          // containing managed new-data.
            $content = $this->variable_manager( $content );
          // This function manages reconstruction of entire page, so must be at end. (Reconstruct and output)
            $content = $this->lbl_management( $content );
        }

      /*
      | @param String/Blob
      | Will manage all of the {{{ (Class): Func, Param1, Param2 }}}
      | calls in the Entry.
      */
      public function lbl_management($content, $debug = false)
        {
          if ($debug)
            {
              echo "<pre>", $content ,"</pre>";
              echo "<pre>", print_r(explode("\n", $content)) ,"</pre>";
            }

          foreach (explode("\n", $content) as $linenum => $line)
            {
              // Remove whitespace.
                $line = rtrim(ltrim($line));

              // Managing possible comments.
                $line = $this->comment_manager($line);

              // Managing "@keyword second" triggers in parse.
                $line = $this->keyword_line_manager($line);

              // Managing if using setter mode to set vars for easier manip later on.
                if ($this->in_setter_mode && $line !== '')
                $line = $this->setter_mode_manager($line);

              // Managing Builder mode.
                if ($this->in_builder_mode)
                { $this->builder->store($line); $line = ''; }

              // Managing if using the if mode to output if statements or kill current line.
                if ($this->in_if_mode && !$this->execute_if_code)
                $line = '';

              // Managing function calls.
                $line = $this->function_call_manager($line);

              // Managing possible classes.
                $line = $this->class_manager($line);

              // Outputting the line after it was parsed.
                echo $line;
            }
        }



      /*
      | @param String/Blob
      | Takes in content from a file or line then will manage for
      | replacing variables.
      | Stack trace revolves around creating a preg-replacable search/replace
      | arrays to then replace all variables.
      */
      public function variable_manager($content)
        {
          $data = $this->data;

          $search  = [];
          $replace = [];

          // Search REGEX example: /\@\{\{(.*?)\}\}/is
          // Though, has to be specialy AQUAINTED.
          // Search REGEX example: /\@\{\{name\}\}/is
          // Search REGEX example: /\@\{\{age\}\}/is
          // Search REGEX example: /\@\{\{job\}\}/is
          // Since -- There'd be many different variables.

          foreach ($data as $lookfor => $put)
            {
              array_push($search,  '/\{\{\s?' . $lookfor . '\s?\}\}/is');
              array_push($replace, $put);
            }

          return preg_replace( $search, $replace, $content );
        }


















        /*
        | @param String
        | Takes in a line of content and parses it when usign the setter
        | mode toggled by a single line of "@setter", will parse this
        | as a variable for the internal class.
        |
        | Line has to be managed as a varset.
        */
        public $official_setter_vars = [];
        public $shorthand_vars = []; // set in constructor.

        public function setter_mode_manager($line)
          {
            $pieces = explode(' = ', $line);
            if (count($pieces) != 2) App::Error('JTE Variable Setter', 'Not one <b>" = "</b> in var setting. (@ Line "<b>'.$line.'</b>")');
            $varname = $pieces[0];
            $toparse = $pieces[1];
            // There's more to this puzzle! The exploded part to the right = array accessor.
            $parse_splits = explode('.', $pieces[1]);
            $vardata_parent = $parse_splits[0];
            $vardata_child  = $parse_splits[1];
            // If the string to lower version of the vardata parent is in the array keys of
            // the shorthand setter vars, venture forth!
            if (in_array( strtolower($vardata_parent), array_keys($this->shorthand_setter_vars)) )
              {
                // Checks if from shorthand var the child is part of array, if so sets true, if not sets false.
                $official_data = (isset(
                  $this->shorthand_setter_vars
                    [ strtolower($vardata_parent) ]
                    [ strtolower($vardata_child) ]
                )) ? true : false;
                $this->official_setter_vars[$varname] = $official_data;
              }
            return '';
          }




        /*
        | @param String/Blob
        | Reconstructs the content and manages the imports and @KEYWORDS.
        | Reacting to imports is related to the public variable in
        | the setting area, look there for more information on keywords
        | that can be used.
        */
        public function keyword_line_manager($line)
        {
          // Checks if line is matching keyword (@).
          if (isset($line[0]) && $line[0] == '@')
          {
            $line = ltrim(rtrim($line, ')'), '(');
            $line = ltrim($line, '@');
            $pieces = explode(' ',$line);
            // Splits and gets the keyword and toload.
            $keyword = (isset($pieces[0])) ? $keyword = $pieces[0] : $keyword = '';
            $loading = (isset($pieces[1])) ? $loading = $pieces[1] : $loading = false;

            switch ($keyword):
              // Managing importing triggers.
              case 'import':
                if (in_array($loading, array_keys($this->import_keywords)))
                  {
                    $loading = $this->import_keywords[ $loading ];
                    require_once( "app/entries/" . $loading );
                    return '';
                  }
                else App::Error('JTE External Importer', "Keyword unknown <b>\"$loading\"</b>, please check the jTE class variable (public \$keywords)");
              break;

              // Managing the Builder references.
              case 'builder':
                $this->in_builder_mode = !$this->in_builder_mode;
                return '';
              break;

              // Rendering the builder
              case 'build':
                $this->in_builder_mode = !$this->in_builder_mode;
                $this->builder->render();
                return '';
              break;

              // Managing the setter trigger.
              case 'setter':
                $this->in_setter_mode = !$this->in_setter_mode;
                return '';
              break;

              // Managing starting of an if trigger statement.
              case 'if':
                if ($loading === '')
                App::Error('JTE If starter', 'No conditional given');
                else if (!in_array( $loading, array_keys($this->official_setter_vars) ))
                App::Error('JTE If starter', 'No official var given for the trigger <b>"'.$loading.'"</b>');
                $this->execute_if_code = $this->official_setter_vars[$loading];
                $this->in_if_mode = true;
              break;

              // Managing a swap of if outputter.
              case 'else':
                $this->execute_if_code = !$this->execute_if_code;
              break;

              // Managing the end of an if statement running.
              case 'endif':
                $this->in_if_mode = false;
              break;

              // Managing a shorthand typeable trigger to kill a session.
              case 'killsession' OR 'ks':
                session_unset();
              break;
            endswitch;
          } else return $line;
        }




        /*
        | @param String
        | Manages if the current line is a comment or not, will return
        | an empty string if so or return the line if it's not a comment.
        */
        public function comment_manager($line)
        {
          if (isset($line[0], $line[1], $line[2]))
          {
            if ($line[0].$line[1].$line[2] === '<@>' || $line[0].$line[1] === '@@')
            return '';
            else return $line;
          } else return $line;
        }
        



        /*
        | @param String
        | Manages if there's a function / class to be called in the scope.
        | Function trigger looks like so:
        | {{ function_name() }} or {{function_name()}}
        */
        public function function_call_manager($line)
        {
          if (isset($line[0], $line[1]))
          if ($line[0] . $line[1] . $line[2] === '{{ ')
          {
            // This is well after the var-replacer, so this has to be a function!
            // Getting the functions name.
            $line = str_replace(['{{', '}}'], ['', ''], $line);
            $line = rtrim(ltrim($line));
            if ($line[strlen($line)-2] . $line[strlen($line)-1] === '()')
            {
              $function_name = preg_replace( "/(.*?)\(\)/is", '$1', $line );
              if (function_exists($function_name))
              {
                $function_name();
                return '';
              }
              else App::Error("jTE -> Call '<b>{$function_name}()</b>'", 'Function not exist, make sure it does.');
            }
          } else return $line;
        }


        /*
        | @param Line
        | Manages if the current line being interpreted is a class or not,
        | trigger looks like so:
        | {{{ ClassName, FunctionName, FnameParam1, FnameParam2, FnameParam3, FnameParam4, FnameParam5 }}}
        */
        public function class_manager($line)
        {

          if (isset($line[0], $line[1], $line[2]))
          if ($line[0] . $line[1] . $line[2] === '{{{')
          {
            // Removes {{{}}} from string.
            $line   = preg_replace( '/\{\{\{(.*?)\}\}\}/is', '$1', $line );
            $pieces = explode(',', $line);
            // Removing whitespace from each piece of aray.
            foreach ($pieces as $index => $piece)
            $pieces[$index] = rtrim(ltrim($piece));
            // Gets the class the user wants to use then pulls from the array.
            $class  = rtrim(ltrim( $pieces[0], '(' ), ')');
            $class  = $this->classes[$class];
            // Gets method.
            $method = $pieces[1];
            // Now managing the input & call of class method.
            for ($i = 2; $i <= 7; $i++)
            if (!isset($pieces[$i])) $pieces[$i] = false;
            // Call.
            $class->$method( $pieces[2], $pieces[3], $pieces[4], $pieces[5], $pieces[6], $pieces[7] );
            return '';
          }
          else return $line;
        }







      //
    }
