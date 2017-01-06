<?php
  class Form
    {
      /*
      | This is a form class meant to help aid in the creation of form's
      | and input cases for websites that re-use content oftenly.
      */

      // ***********************************************************************

        public $current_form_id  = false;
        public $using_errorpalce = false;
        public $current_errorplace_id = false;

      // ***********************************************************************

      // Constructor for if user simply wants to generate the form from there.
      public function __construct($makenow = false)
        {
          if ($makenow !== false)
            {
              $this->start($makenow);
              return $this;
            }
        }

      // If no speific methods are called, will call this method to create an element.
      public function __call($element_name, $types_array)
        {
          if (isset($types_array['solo'])) $is_solo = $types_array['solo']; else $is_solo = true;
          $this->element($element_name, $types_array[0], $is_solo);
          return $this;
        }

      // Method called when user requesting to create a new form. [$for = new Form; $form('form_id');].
      public function __invoke($form_id = 'form')
        {
          $this->start($form_id);
          return $this;
        }

      // Starts the form creation.
      public function start($form_id)
        {
          $this->current_form_id = $form_id;
          echo "<form id=\"{$form_id}\">";
        }

      // Generates a plain HTML element - Conforming to the correct XML standards.
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
      public function generate_fuckforms($type, callable $success)
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
