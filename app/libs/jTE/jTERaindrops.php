<?php
  class jTERaindrops
    {
      /*
      | Class containing all builders for umbrellas.
      | Such as Form->GenerateJS, GenerateJS is supplied here as
      | a real method.
      */

      //***********************************************************

        public $something;

      //***********************************************************

      /*
      | @param Array
      | Will take in two arrays and force the left array to conform
      | the same as the next array.
      */
      public function force($forcing, $forcer = [])
        {
          $forcing = array_keys($forcing);
          asort($forcing); asort($forcer);

          // Remaking the arrays in the most annoying way possible.
          $count = 0; foreach ($forcing as $index => $floop) {
            $remade_forcing_loop[$count] = $floop;
          $count++; }
          $count = 0; foreach ($forcer as $index => $floop) {
            $remade_forcer_loop[$count] = $floop;
          $count++; }
          // I haven't slept for 3 days, please forgive me.

          $forcing = $remade_forcing_loop;
          $forcer  = $remade_forcer_loop;

          if ($forcing == $forcer)
          return true;
          else App::Error('jTE Forcer called', "<b>Array forcer not equal to needs supplied from builder</b>");
        }


      /*
      | @param Array
      | -----------------------------------------------------------
      | UMBREALLA: FORM
      | Takes in the class buffer so can quickly manipulate and
      | build the js for a form.
      */
      public function GenerateJS($buffer)
        {
          $forcer = ['name','type','formid','eplace','goto'];
          $this->force($buffer, $forcer);
          extract($buffer);

          $js = new jekjs;
          $js()->func('window.jek.form_manager', [
            $formid, $type, $eplace, $goto
          ])->escript();
        }





      //
    }
