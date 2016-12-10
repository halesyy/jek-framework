<?php
  class IndexJoint extends Joint
  {

    public function LoadUserData($userid)
      {
        $set = $this->psm->query_set("SELECT * FROM users WHERE id = :id", [':id' => $userid]);
        return $set;
      }

  }
