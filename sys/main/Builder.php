<?php
  class Builder
    {
      /*
      | This is a class meant to quickly let you create forms and such using basic functions.
      | Most of the styling is done by Bootstrap as that's the easiest way to quickly deploy.
      */


      /*
      SAMPLE DATA:
      [
        ['main' => 'username', 'placeholder' => 'Username', 'type' => 'text', 'extra_classes' => 'some classes you may want']
        ['main' => 'password', 'placeholder' => 'Password', 'type' => 'password', 'extra_classes' => 'some classes you may want']
      ]
      When you set the "main" for it, that determines the NAME, ID and other information about the ipt.
      The ID is set to MAIN-IPT for no collisions with current ID's.
      */
      public static function Inputs($inputs_array)
        {
          foreach ($inputs_array as $ipt_d)
            {


            }
        }

    }
