<?php
  class P_Drivers extends P_Queries {
    /*
    | Class extension to help work on drives and their functionality.
    */

    public function Driver_Manager($driver_name, $driver_data)
      {
        if (method_exists($this, $driver_name))
          $this->$driver_name($driver_data);
        else
          $this->Error("Driver <b>$driver_name</b> not exist");
      }




    /*
    | All Driver management functions.
    */

      public function Safe($yesorno)
        {
          if ($yesorno) $this->safe = true;
            else $this->safe = false;
        }
  }
