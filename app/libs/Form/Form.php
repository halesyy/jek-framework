<?php
  class Form
    {
      /*
      | This is a form class meant to help aid in the creation of form's
      | and input cases for websites that re-use content oftenly.
      |
      | METHOD DECLARATIONS.
      | @param TYPE (0)
      | Information on Method.
      */

      // ***********************************************************************

        public $current_form_id  = false;
        public $using_errorpalce = false;
        public $current_errorplace_id = false;

      // ***********************************************************************


      /*
      | @param String, Array
      | When the user calls a method that doesn't exist in the class,
      | will use the "element" method to create a HTMLDOM element.
      */
      public function __call($element_name, $types_array)
        {
          if (isset($types_array[0])) $ta = $types_array[0];
          else $ta = [];
          if (isset($ta['solo'])) { $is_solo = $ta['solo']; unset($ta['solo']); } else $is_solo = true;
          $this->element($element_name, $ta, $is_solo);
          return $this;
        }



      /*
      | @param String, Array
      | When invocation occours ( $classinstance() ) will begin the forms creation
      | and call the appropriate start method.
      */
      public function __invoke($form_id = 'form', $optional_types = [])
        {
          $this->start($form_id, $optional_types);
          return $this;
        }



      /*
      | @param String, Array
      | The appropriate method to be called when beginning your forms creation.
      | Meant to be the first method called.
      */
      public function start($form_id, $container_types_array = false)
        {
          if ($container_types_array === false) $container_types_array = [];
          $this->current_form_id = $form_id;
          echo "<form id=\"{$form_id}\">";
          $default = ['class' => 'form-container'];
          if (isset($container_types_array['class']))
            {
              $default['class'] .= ' '.$container_types_array['class'];
              unset($container_types_array['class']);
            }
          $merged = array_merge($default, $container_types_array);
          $this->start_div( $merged );
        }



      /*
      | @param None
      | Called when the form has finished being created and required ending.
      */
      public function end()
        {
          echo "</div></form>";
          return $this;
        }



      /*
      | @param String, Array, Bool
      | Will create a base element for HTML using the correct XML standards.
      | - Can be used as a function itself to construct DOM elements.
      | - BOOL Will determine if creation of element ends in ' /' or ''.
      */
      public function element($element_name, $types_array = false, $is_solo = true)
        {
          if ($types_array === false) $types_array = [];
          if ($is_solo) $end = ' /';
          else $end = '';
          $elm = "<{$element_name} ";
            foreach ($types_array as $key => $value)
            $elm .= "{$key}=\"{$value}\"";
          $elm .= "{$end}>";
          echo $elm;
          return $this;
        }








      /*
      | @param Array
      | Shorthand function for creating an input HTML element.
      | (Just calls the element method)
      */
      public function input($types_array)
        {
          $this->element('input', $types_array, true);
          return $this;
        }




      /*
      | @param Array
      | Creates and ends a div using the element function.
      */
      public function start_div($types_array)
        {
          $this->element('div', $types_array, false);
          return $this;
        }
      public function end_div()
        {
          $this->element('/div', [], false);
          return $this;
        }



      /*
      | @param String
      | Generates the errorplace to be used with the method generatejs()
      | in this class to aid with making use of the frontend framework.
      */
      public function errorplace($errorplace_id = false)
        {
          if ($errorplace_id === false) $errorplace_id = $this->current_form_id;
          $errorplace_id .= '-errorplace';
          $this->using_errorplace = true;
          $this->current_errorplace_id = $errorplace_id;
          // Generates divs.
          $this->start_div(['id' => "{$errorplace_id}"]);
          $this->end_div();
          return $this;
        }




      /*
      | @param None
      | Methods to create bootstrap rows and end them,
      | Rows are needed if you're going to be using the shorthand column
      | methods as they're the "container" for them.
      */
      public function row()
        {
          $this->start_div(['class' => 'row']);
          return $this;
        }
      public function endrow()
        {
          $this->end_div();
          return $this;
        }



      /*
      | @param None
      | Methods to create columns in a shorthand manor.
      | Shorthand starting divs and adding wanted classes.
      */
      public function half()
        {
          $this->start_div(['class' => 'col-lg-6 col-md-6 col-sm-12 col-xs-12']);
          return $this;
        }
      public function third()
        {
          $this->start_div(['class' => 'col-lg-4 col-md-4 col-sm-4 col-xs-12']);
          return $this;
        }
      public function fourth()
        {
          $this->start_div(['class' => 'col-lg-3 col-md-3 col-sm-3 col-xs-12']);
          return $this;
        }


      /*
      | @param None
      | These are the ending functions for columns generated for Bootstrap.
      | Each time a new add is made there must be a new entry.
      | Later to be re-created using the __get magic method manager.
      */
      public function endhalf()
        {
          $this->end_div(); return $this;
        }
      public function endthird()
        {
          $this->end_div(); return $this;
        }
      public function endfourth()
        {
          $this->end_div(); return $this;
        }

      /*
      | @param None
      | These are the junction methods when you want to end a part
      | - The methods are to junction a created part with another part.
      | - Ex.
      |     row
      |       third
      |         input
      |       thirdjunction
      |         input
      |       thirdjunction
      |         input
      |       endthird
      |     endrow
      */
      public function halfjunction()
        {
          $this->endhalf();
          $this->half();
          return $this;
        }
      public function thirdjunction()
        {
          $this->endthird();
          $this->third();
          return $this;
        }
      public function fourthjunction()
        {
          $this->endfourth();
          $this->fourth();
          return $this;
        }



      // Creates a text-input.
      public function text($placeholder = 'Username', $name = false, $types_array = false)
        {
          if ($types_array === false) $types_array = [];
          $this->start_div(['class' => 'jf-ipt-container']);
            $this->input(array_merge([
              'type'        => 'text',
              'placeholder' => $placeholder,
              'name'        => ($name !== false) ? $name : explode(' ',strtolower($placeholder))[0]
            ], $types_array));
          $this->end_div();
          return $this;
        }

      // Creates a password-input.
      public function password($placeholder = 'Password', $name = false, $types_array = false)
        {
          if ($types_array === false) $types_array = [];
          $this->start_div(['class' => 'jf-ipt-container']);
            $this->input(array_merge([
              'type'        => 'password',
              'placeholder' => $placeholder,
              'name'        => ($name !== false) ? $name : explode(' ',strtolower($placeholder))[0]
            ], $types_array));
          $this->end_div();
          return $this;
        }

      // Creates a email-input.
      public function email($placeholder = 'Email', $name = false, $types_array = false)
        {
          if ($types_array === false) $types_array = [];
          $this->start_div(['class' => 'jf-ipt-container']);
            $this->input(array_merge([
              'type'        => 'email',
              'placeholder' => $placeholder,
              'name'        => ($name !== false) ? $name : explode(' ',strtolower($placeholder))[0]
            ], $types_array));
          $this->end_div();
          return $this;
        }

      // Creates the submit button on a form.
      public function submit($placeholder = 'Submit', $name = false, $types_array = false)
        {
          if ($types_array === false) $types_array = [];
          $this->start_div(['class' => 'jf-submit']);
            $this->input(array_merge([
              'type'  => 'submit',
              'value' => $placeholder,
              'name'  => ($name !== false) ? $name : explode(' ',strtolower($placeholder))[0]
            ], $types_array));
          $this->end_div();
          return $this;
        }














      // Called when wanting to start a JS script.
      public function start_script()
        {
          $this->element('script', ['type' => 'text/javascript'], false);
          return $this;
        }
      // Called when wanting to put content in the middle of a script.
      public function script(callable $script, $add_shell = false)
        {
          if ($add_shell)
            {
              $this->start_script();
              $script();
              $this->end_script();
            }
          else $script();
          return $this;
        }
      // Called when wanting to end script.
      public function end_script()
        {
          $this->element('/script', [], false);
          return $this;
        }






      // Generate the window.jek.fuckforms wanted layout.
      public function generatejs($type, callable $success = null)
        {
          $this->start_script();
?>
$(document).ready(function(){
  window.jek.fuckforms('<?=$this->current_form_id?>', '<?=$type?>', '<?=$this->current_errorplace_id?>', function(){
    <?php if (isset($success)) $success(); ?>
  });
});
<?php
          $this->end_script();
        }

      // Generate the JS in a force way without using class vars.
      public function forcegeneratejs($type, $formid, $errorplaceid, $goto = false)
        {
          $this->start_script();;
?>
$(document).ready(function(){
  window.jek.fuckforms('<?=$formid?>', '<?=$type?>', '<?=$errorplaceid?>', function(){
    <?php if ($goto !== false): ?>
      window.location.href = "#!/<?=$goto?>";
    <?php else: ?>
      window.location.reload();
    <?php endif; ?>
  });
});
<?php
          $this->end_script();
        }
    }



    /*
    | Global fucntions that need to be in the scope for other classes to use.
    | Such as CSRF generation, and anything form-related.
    |
    | All of these functions are built for the creation, checking is done from the
    | API for auth.
    */


    function generate_token()
      {
        $charset     = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ:=;,.[]{}_+-';
        $charset_len = strlen($charset) - 1;
        $csrf_token  = '';
          for ($i = 0; $i < 128; $i++)
          $csrf_token .= $charset[rand(0, $charset_len)];
        return $csrf_token;
      }


    function csrf_make($return = false)
      {
        $token = generate_token();
        $_SESSION['csrf_token'] = $token;
        $ipt   = "<input type='hidden' name='token' value='{$token}' />";
        if ($return) return $ipt; else echo $ipt;
      }



    #
