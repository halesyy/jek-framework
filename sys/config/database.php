<?php
  /*
  |----------------------------------------------------------------------------------
  | CONFIG -- DATABASE / PSM
  |----------------------------------------------------------------------------------
  | This is the config file for your database connection.
  | The prefered engine for con. is PSM (PDO Rewrite for easy function use and
  | auto-binding queries).
  |
  | If you otherwise want to use PDO - You may say "set_pdo_var = true" and you'll
  | be supplied with a PDO variable for usage in your Joins (Models).
  | ($this->database = Handler)
  | ($this->pdo      = Handler)
  | ($this->pdm      = Handler)
  |
  | CONTAINS
  |
  |   |- Database connection variables.
  |
  |----------------------------------------------------------------------------------
  */

  /*Run the PSM extension.                    -- An easy-to-use Database interaction tool created by Jek himself.*/
  $cfg['db']['run_psm']                  = true;
  /*On connection create also create PDO var. -- PSM & PDO.*/
  $cfg['db']['set_pdo_var']              = false;

  /*Bypass default-string management.*/
  $cfg['db']['byp_def_iptstring']        = true;

  /*Your connection details.*/
  $cfg['db']['connection'] = [
    'host' => 'localhost',
    'db'   => 'agency',
    'user' => 'root',
    'pass' => 'password',
    'safe' => true
  ];

  /*
  | -----------------------------------------------------------------------------
  | Management for the Auth class load.
  | EXPLAINED:
  | -----------------------------------------------------------------------------
  | algo     = Algorithm you want to use when hashing.
  | salt     = Salt you wanna salt your strings with when hashing. (make unique)
  | database-info =
  |  >>table..: The table your users are stored in.
  |  >>first..: Your "Username" table.
  |  >>secnd..: Your "Password" table.
  | -----------------------------------------------------------------------------
  */
  $cfg['db']['use_auth_class'] = true;
  $cfg['db']['auth'] = [
    'algo' => 'gost',
    'salt' => 'nS(s)dk2asd902',
    'database-info' => [
      'table' => 'users',
      'first' => 'username',
      'secnd' => 'password'
    ]
  ];






  //
