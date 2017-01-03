<?php
  class IndexJoint extends Joint
  {

    public function PSM_Tester()
      {
        $psm = $this->psm;

        $username  = 'jek';

        if ($psm->rows( $psm->short_cstatement(['users','username',"username = {$username}"])['statement'], $psm->tempbinds ))
          echo 'This username is in use!';
        else
          echo 'This username is not in use!';
      }

  }
