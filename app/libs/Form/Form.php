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
      public function element($element_name, $types_array, $is_solo = true)
        {
          if ($is_solo) $end = ' /';
          else $end = '';
          $elm = "<{$element_name} ";
            foreach ($types_array as $key => $value)
            $elm .= "{$key}=\"{$value}\"";
          $elm .= "{$end}>";

          echo $elm;
          return $this;
        }








      // Generator for inputs.
      public function input($types_array)
        {
          $this->element('input', $types_array, true);
          return $this;
        }
      // Generator for making divs.
      public function start_div($types_array)
        {
          $this->element('div', $types_array, false);
          return $this;
        }
      public function end_div()
        { echo "</div>"; }
      // Putting the "errorplace" for users to use if wanting to use the Frontend API.
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




    // All bootstrap-related methods.
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
      public function endhalf()
        { $this->end_div(); return $this; }
      public function endthird()
        { $this->end_div(); return $this; }
      public function endfourth()
        { $this->end_div(); return $this; }



      // Creates a text-input.
      public function text($placeholder = 'Username', $name = false)
        {
          $this->input([
            'type'        => 'text',
            'placeholder' => $placeholder,
            'name'        => ($name !== false) ? $name : explode(' ',strtolower($placeholder))[0]
          ]);
          return $this;
        }

      // Creates a password-input.
      public function password($placeholder = 'Password', $name = false)
        {
          $this->input([
            'type'        => 'password',
            'placeholder' => $placeholder,
            'name'        => ($name !== false) ? $name : explode(' ',strtolower($placeholder))[0]
          ]);
          return $this;
        }

      // Creates a password-input.
      public function email($placeholder = 'Email', $name = false)
        {
          $this->input([
            'type'        => 'email',
            'placeholder' => $placeholder,
            'name'        => ($name !== false) ? $name : explode(' ',strtolower($placeholder))[0]
          ]);
          return $this;
        }

      // Creates the submit button on a form.
      public function submit($placeholder = 'Submit', $name = '')
        {
          $this->start_div(['class' => 'form-submit']);
            $this->input([
              'type'  => 'submit',
              'value' => $placeholder,
              'name'  => $name
            ]);
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
      public function generatejs($type, callable $success)
        {
          $this->start_script();
?>
$(document).ready(function(){
  window.jek.fuckforms('<?=$this->current_form_id?>', '<?=$type?>', '<?=$this->current_errorplace_id?>', function(){
<?php $success() ?>
});
});
<?php
          $this->end_script();
        }
    }
