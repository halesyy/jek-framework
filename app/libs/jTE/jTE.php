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

        public $random;

      // ***************************************************************


      /*
      | @param String, Array
      | This method will take in a filename and load the content
      | using an output buffer to render the PHP, then gather the
      | content and use the jTE rendering engine to render all other
      | content such as variables, etc...
      */
      public function file($filename, $data = [])
        {
          if (file_exists( $filename ))
            {
              // Setting of variables that are going to be used for PHP itself.
                $form = new Form;
              // Gathering page data by parsing the PHP file.
                ob_start();
                include_once "{$filename}";
                $content = ob_get_clean();
              // Runs the Interpreter.
                $this->interpreter($content, $data);
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
      public function interpreter($content, $data = [])
        {
          // Will call appropriate methods to get new data sets back
          // containing managed new-data.
            $content = $this->function_manager( $content );
            $content = $this->variable_manager( $content, $data );
          // This function manages reconstruction of entire page, so must be at end. (Reconstruct and output)
            $content = $this->class_shorthand_manager( $content );
        }



      /*
      | @param String/Blob
      | Method to look in the content for functions to be called.
      | Such as {{ csrf_make() }} would call the function csrf_make();
      */
      public function function_manager($content)
        {
          $func_lookfor_replacer = [
            'csrf_make' => csrf_make(true)
          ];
          $search = $replace = [];
            foreach ($func_lookfor_replacer as $function_name => $replacer):
              array_push($search,  '/\{\{\s?' . $function_name . '\(\)\s?\}\}/is');
              array_push($replace, $replacer);
            endforeach;
          $content = preg_replace($search, $replace, $content);
          return $content;
        }


      /*
      | @param String/Blob
      | Will manage all of the {{{ (Class): Func, Param1, Param2 }}}
      | calls in the Entry.
      */
      public function class_shorthand_manager($content)
        {
          // The called (Class):, Form = (Form): (...)
          $classes = [
            'Form' => load_class('Form')
          ];

          // Cause of the differental calls, the content has to be looped then put
          // back together as looping to make the class system work as smoothly as
          // possible.

          $reconstructor = '';
          foreach (explode("\n", $content) as $line)
            {
              // Remove whitespace.
              $line = ltrim($line);
              $line = rtrim($line);
              // Managing possible comments.
                if (isset($line[0], $line[1], $line[2]))
                  {
                    if ($line[0] . $line[1] . $line[2] === '<@>')
                    $line = '';
                  }
              // Managing possible classes.
                if (isset($line[0], $line[1], $line[2]))
                  if ($line[0] . $line[1] . $line[2] === '{{{')
                  {
                    // Removes {{{}}} from string.
                    $line   = preg_replace( '/\{\{\{(.*?)\}\}\}/is', '$1', $line );
                    $pieces = explode(',', $line);
                    // Removing whitespace from each piece of aray.
                    foreach ($pieces as $index => $piece)
                      {
                        $pieces[$index] = rtrim(ltrim($piece));
                      }
                    // Gets the class the user wants to use then pulls from the array.
                    $class  = rtrim(ltrim( $pieces[0], '(' ), ')');
                    $class  = $classes[$class];
                    // Gets method.
                    $method = $pieces[1];
                    // Now managing the input & call of class method.
                    for ($i = 2; $i <= 7; $i++)
                    if (!isset($pieces[$i])) $pieces[$i] = false;
                    // Call.
                    $class->$method( $pieces[2], $pieces[3], $pieces[4], $pieces[5], $pieces[6], $pieces[7] );
                  }
                else echo $line;
            }

          // return $content;
        }



      /*
      | @param String/Blob
      | Takes in content from a file or line then will manage for
      | replacing variables.
      | Stack trace revolves around creating a preg-replacable search/replace
      | arrays to then replace all variables.
      */
      public function variable_manager($content, $data = [])
        {
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









      //
    }
