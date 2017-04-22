<?php

  $Compiler = new CompileSS;
  $Compiler->Manage(true, [
    // Optionset.
  ]);

  class CompileSS
  {
    // Var placements.
    public $Internal_Buffer = [];

    public function Manage($use = true, $options = [])
      {
        header('Content-type: text/css');
        $file = '/css_real/';
        $file_location = str_replace('/public/css/','',$_SERVER['REQUEST_URI']);
        $file .= $file_location;
        $file = '..'.$file;
        // Actual CSS data.
        $css_data = @file_get_contents($file);
        $this->Compile($css_data);
      }

    public function Compile($data)
      {
        foreach (explode("\n",$data) as $line):
          if (strlen(trim($line)) > 0 && trim($line)[0] == '@')
            {
              $defs = explode(' = ',$line);
              $defs[1] = str_replace(';','',$defs[1]);
              $defs[0] = str_replace('@','',$defs[0]);
              $this->Var_Set($defs[0],$defs[1]);
            }
          else
            {
              //construct regex
              $sar = $this->SAR_Constructor();
              $search  = $sar[0];
              $replace = $sar[1];
              // print_r($sar);
              $line = preg_replace($search, $replace, $line);
              echo $line;
            }
        endforeach;
      }

    public function Var_Set($varname, $vardata)
      {
        $this->Internal_Buffer[trim($varname)] = trim($vardata);
      }

    public function SAR_Constructor()
      {
        //: '/\@'.$varname.'/is'
        //: ''.$vardata.''
        $vars = $this->Internal_Buffer;
        $s = $r = [];
          foreach (array_keys($vars) as $vardata)
          array_push($s,'/\@'.$vardata.'/is');
          foreach (array_values($vars) as $vardata)
          array_push($r,$vardata);
        return [$s,$r];
      }


  }
