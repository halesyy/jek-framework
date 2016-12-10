<?php
  /*
  |----------------------------------------------------------------------------------
  | CONFIG -- MANAGER
  |----------------------------------------------------------------------------------
  | NOTE
  |  All real config files are in the "sys/config" file, please add configs and
  |  manage/load them here.
  |
  | THis file loads the configs then manages them.
  |----------------------------------------------------------------------------------
  */

  //Main config.
  require_once "sys/config/config.php";
  if ($cfg['main']['run_html_head_management'])
    {
      require_once "sys/build/classes/html_head/html_head.class.php";
      require_once "sys/build/html_head.php";
    }

  //Database config.
  require_once "sys/config/database.php";
  //Loading the PSM Files.
  require_once "sys/build/classes/psm/PSMExtra.php";
  require_once "sys/build/classes/psm/PSMQuery.php";
  require_once "sys/build/classes/psm/PSMMain.php";
  if ( implode( ' ', array_values($cfg['db']['connection']) ) != 'localhost test root EM 1' || $cfg['db']['byp_def_iptstring'])
    {
        GLOBALS::SET('PSM_CONNECTION_VARS',
          "{$cfg['db']['connection']['host']} "
         ."{$cfg['db']['connection']['db']} "
         ."{$cfg['db']['connection']['user']} "
         ."{$cfg['db']['connection']['pass']} "
       );

       //Making the PSM connection for other classes to use if need reference.
       $psm = new PSM(GLOBALS::GET('PSM_CONNECTION_VARS'), [
         'safeconnection' => $cfg['db']['connection']['safe']
       ]);

       //Setting up the auth class if defined.
       if ($cfg['db']['use_auth_class'])
        {
          require_once "sys/build/classes/psm/PSMAuth.php";
          $auth = new Auth(
            $cfg['db']['auth']['algo'],
            $cfg['db']['auth']['salt'],
            $psm,
            $cfg['db']['auth']['database-info']
          );
          GLOBALS::SET('auth', $auth);
        }
        GLOBALS::SET('psm', $psm);

      //Management for the user wanting a PDO variable.
      if ($cfg['db']['set_pdo_var'])
        $pdo = $psm->handler;
    }
  else
    echo '<h3 style="font-family: Arial;">DATABASE ENTRIES NOT CHANGED FROM DEFAULT</h1>';
