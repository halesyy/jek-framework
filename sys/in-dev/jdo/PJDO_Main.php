<?php
  class PJDO extends P_Drivers
    {
      /*
      |------------------------------------------------------------------------
      | JEK DATABSE OBJECTS -- PDO RE-WRITE, EXT OF PSM.
      |
      | VERSION: 1.0
      |------------------------------------------------------------------------
      | JDO is a simple OOP database interaction tool that helps life with
      | databases an easier task.
      |
      | PSM (http://github.com/halesyy/psm) is the first instance of this,
      | JDO is a re-write of this.
      |------------------------------------------------------------------------
      */

      //***********************************************************************

        protected $handler   = false;
        protected $drivers   = false;
        protected $connected = false;

        public    $version   = "1.0";

        /*All driver-related variables used by P_Drivers.*/
        protected $safe      = true;

      //***********************************************************************

      public function __construct($host, $database, $username, $password, $drivers)
        {
          //Driver/Option management.
            $this->drivers = $drivers;
            foreach ($drivers as $call_name => $data)
              $this->Driver_Manager($call_name, $data);

          //Trying to connect to the database.
            try {
              $pdo = new PDO(
                "mysql:host=$host;dbname=$database;charset=utf8",
                $username,
                $password
              );

              $this->connected = true;
              $this->handler   = $pdo;
            } catch(PDOException $e) {
              if ($this->safe) $this->Error('Failed to connect to Database.');
              else echo
                "<pre>","PJDO FAIL CONNECTION RESULTS: ((UNSAFE))\nHOST: $host\nDABA: $database\nUSER: $username\nPASS: $password","</pre>";
            }
        }
    }
