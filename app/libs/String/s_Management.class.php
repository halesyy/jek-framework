<?php
  class s_Management extends s_Settings {
    /*
      This is the class for managing the chains, etc...
      What's called from the frontlines.
    */



    /*Sets the current string we're working with.*/
      public function set_string($ipt)
        {
          $this->pws = $ipt;
          return $this;
        }




    /*Filters the current string.*/
      public function filter($filter_array = false)
        {
          //Getting the correct filter to use.
          if ($filter_array)
            $filter_array = $filter_array;
          else
            $filter_array = $this->filter_array;

          if ( count(explode( $this->seperator, $this->pws )) != 1)
            {
              //Checking if the strings = in array. -- For multiple strings broken up by the seperator.
              $ret = true;
                foreach ( explode( $this->seperator, $this->pws ) as $index => $str_val )
                  {
                    if ( $filter_array[$index] != $str_val )
                      $ret = false;
                  }
                $this->result = $ret;
            }
          else
            {
              //Checking if string = in array. -- For a single string.
              if ( in_array( $this->pws, $filter_array ) )
                $this->result = true;
              else
                $this->result = false;
            }

          //Setting the filter fail or no fail.
          if (!$this->result) $this->filter_fail = true;

          //Setting the type to "torf" = True or False.
          $this->last_type = 'torf';
          return $this;
        }

    /*Makes sure the iptstring is the correct type.*/
      public function type($vartype)
        {
          //Setting the keywords for types.
          $int_keyw = ['int','number','numeric','intiger'];
          $txt_keyw = ['words','text','string','blob','varchar','str'];

          if ( in_array($vartype, $int_keyw) )
            {
              //User wants an intiger.
              $this->result = is_numeric( $this->pws );
            }
          else if ( in_array($vartype, $txt_keyw) )
            {
              //User wants a string.
              $this->result = !is_numeric( $this->pws );
            }

          $this->last_type = 'torf';
          return $this;
        }




    /*Opts the current buffer - the result from recent functions.*/
      public function opt()
        {
          if ( $this->last_type == 'torf' && $this->filter_fail === false )
            return $this->result;
          else if ( $this->filter_fail )
            return false;
          else if ($this->last_type == 'array')
            return $this->result_a;
        }
    /*Opts the current, using a display function instead.*/
      public function prnt()
        {
          $this->display(

            $this->opt()

          );
        }
    /*Json output function for opting json.*/
      public function json_opt($settings_arr = false)
        {
          return json_encode([
            $settings_arr[0] => $this->opt()
          ]);
        }
    /*Json output for a fail message.*/
      public function json_fail_opt($error_msg = false, $return_html = false)
        {
          //Management for a json error message. - Essentially the title of the JSON opt.
          if (!$error_msg) $ret['error'] = 'JSON_ERROR';
            else $ret['error'] = $error_msg;
          $ret['rtype'] = 'e';
          if ($return_html !== false) $ret['html'] = $return_html;
          echo json_encode($ret);
        }
    /*Json output for a success message.*/
      public function json_success_opt($success_msg = false, $return_html = false)
        {
          //Management for a json error success. - Essentially the title of the JSON opt.
          if (!$success_msg) $ret['success'] = 'JSON_SUCCESS';
            else $ret['success'] = $success_msg;
          $ret['rtype'] = 's';
          if ($return_html !== false) $ret['html'] = $return_html;
          echo json_encode($ret);
        }

    /*Looks for certian characters in string and puts in temp if found.*/
      public function lookfor($ipt)
        {
          foreach ( explode( $this->seperator, $ipt ) as $lookfor )
            {
              if ( $this->string_contains( $lookfor, $this->pws ) === true )
                {
                  array_push( $this->result_a, $lookfor );
                }
            }
          $this->last_type = 'array';
          return $this;
        }


    /*Function to return true|false if PARAM1 is in PARAM2.*/
      public function string_contains($lookfor, $in)
        {
          if ( strpos($in, $lookfor) !== false)
            return true;
          else
            return false;
        }




    /*Functions not meant for chaining.*/
      public function filter_e($filter_arr, callable $true, callable $false)
        {
          if (!$filter_arr) $filter_arr = $this->filter_array;
          $ret = true;
          foreach ( explode( $this->seperator, $this->pws ) as $index => $piece )
            {
              if ( $piece !== $filter_arr[$index] )
                $ret = false;
            }
          //Management for callbacks.
          if ($ret) $true($this);
            else $false($this);
        }







      //
  }
