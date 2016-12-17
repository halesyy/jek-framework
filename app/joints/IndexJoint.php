<?php
  class IndexJoint extends Joint
  {

    public function JDO()
      {
        include "sys/in-dev/jdo/PJDO_Helpers.php";
        include "sys/in-dev/jdo/PJDO_Chains.php";
        include "sys/in-dev/jdo/PJDO_Queries.php";
        include "sys/in-dev/jdo/PJDO_Drivers.php";
        include "sys/in-dev/jdo/PJDO_Main.php";

        $j = new PJDO('localhost', 'test', 'root', '', [
          'safe' => true
        ]);

        $q = $j->single("SELECT * FROM test WHERE id = :id", [':id' => 2]);
        $j->Display($q);
      }

  }
